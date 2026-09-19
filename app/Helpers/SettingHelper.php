<?php

use App\Models\Setting;

if (!function_exists('setting')) {
    /**
     * Get a setting value by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting($key = null, $default = null)
    {
        static $settings = null;

        if ($settings === null) {
            $settings = Setting::current();
        }

        if ($key === null) {
            return $settings;
        }

        return $settings->{$key} ?? $default;
    }
}

if (!function_exists('storage_image_url')) {
    /**
     * Get validated public URL for uploaded storage image, falling back gracefully if missing.
     *
     * @param string|null $path
     * @param string|null $fallbackUrl
     * @return string
     */
    function storage_image_url($path, $fallbackUrl = null)
    {
        if (!empty($path)) {
            if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
                return $path;
            }

            $cleanPath = ltrim(str_replace('\\', '/', $path), '/');

            if (str_starts_with($cleanPath, 'storage/')) {
                $cleanPath = substr($cleanPath, 8);
            }
            if (str_starts_with($cleanPath, 'public/')) {
                $cleanPath = substr($cleanPath, 7);
            }

            $fullStoragePath = storage_path('app/public/' . $cleanPath);
            $fullPublicStoragePath = public_path('storage/' . $cleanPath);
            $fullPublicPath = public_path($cleanPath);

            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($cleanPath) 
                || file_exists($fullStoragePath) 
                || file_exists($fullPublicStoragePath)) {
                return asset('storage/' . $cleanPath);
            }

            if (file_exists($fullPublicPath)) {
                return asset($cleanPath);
            }
        }

        return $fallbackUrl ?: asset('assets/logo/logo magetan.png');
    }
}
