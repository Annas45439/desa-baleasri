<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageOptimizer
{
    /**
     * Store and automatically compress uploaded image while maintaining sharp quality.
     */
    public static function compressAndStore(
        UploadedFile $file,
        string $folder,
        string $disk = 'public',
        int $maxWidth = 1600,
        int $quality = 82
    ): string {
        Storage::disk($disk)->makeDirectory($folder);

        $extension = strtolower($file->getClientOriginalExtension() ?: $file->guessExtension() ?: 'jpg');
        $filename = Str::random(40) . '.' . $extension;
        $targetPath = storage_path("app/public/{$folder}/{$filename}");

        @mkdir(dirname($targetPath), 0777, true);

        if (extension_loaded('gd') && function_exists('imagecreatetruecolor')) {
            try {
                if (static::optimizeWithGd($file->getRealPath(), $targetPath, $maxWidth, $quality)) {
                    return "{$folder}/{$filename}";
                }
            } catch (\Throwable $e) {
                // Fail-safe: fallback to standard store
            }
        }

        return $file->storeAs($folder, $filename, $disk);
    }

    private static function optimizeWithGd(string $sourcePath, string $targetPath, int $maxWidth, int $quality): bool
    {
        $info = @getimagesize($sourcePath);
        if (!$info) {
            return false;
        }

        [$width, $height, $type] = $info;

        $srcImg = match ($type) {
            IMAGETYPE_JPEG => @imagecreatefromjpeg($sourcePath),
            IMAGETYPE_PNG  => @imagecreatefrompng($sourcePath),
            IMAGETYPE_WEBP => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($sourcePath) : false,
            IMAGETYPE_GIF  => @imagecreatefromgif($sourcePath),
            default        => false,
        };

        if (!$srcImg) {
            return false;
        }

        if ($type === IMAGETYPE_JPEG && function_exists('exif_read_data')) {
            try {
                $exif = @exif_read_data($sourcePath);
                if (!empty($exif['Orientation'])) {
                    $srcImg = match ($exif['Orientation']) {
                        3 => imagerotate($srcImg, 180, 0),
                        6 => imagerotate($srcImg, -90, 0),
                        8 => imagerotate($srcImg, 90, 0),
                        default => $srcImg,
                    };
                    $width = imagesx($srcImg);
                    $height = imagesy($srcImg);
                }
            } catch (\Throwable $e) {
            }
        }

        $newWidth = $width;
        $newHeight = $height;

        if ($width > $maxWidth || $height > $maxWidth) {
            if ($width >= $height) {
                $newWidth = $maxWidth;
                $newHeight = (int) max(1, round(($height / $width) * $maxWidth));
            } else {
                $newHeight = $maxWidth;
                $newWidth = (int) max(1, round(($width / $height) * $maxWidth));
            }
        }

        $dstImg = imagecreatetruecolor($newWidth, $newHeight);

        if ($type === IMAGETYPE_PNG || $type === IMAGETYPE_WEBP) {
            imagealphablending($dstImg, false);
            imagesavealpha($dstImg, true);
            $transparent = imagecolorallocatealpha($dstImg, 255, 255, 255, 127);
            imagefilledrectangle($dstImg, 0, 0, $newWidth, $newHeight, $transparent);
        }

        imagecopyresampled($dstImg, $srcImg, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        $saved = match ($type) {
            IMAGETYPE_PNG  => imagepng($dstImg, $targetPath, 8),
            IMAGETYPE_WEBP => function_exists('imagewebp') ? imagewebp($dstImg, $targetPath, $quality) : false,
            default        => imagejpeg($dstImg, $targetPath, $quality),
        };

        imagedestroy($srcImg);
        imagedestroy($dstImg);

        return (bool) $saved;
    }
}