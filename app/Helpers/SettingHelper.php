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
     * @param string|null $path  Path relative to storage/app/public (e.g. "kepala-desa/xxx.jpg")
     * @param string|null $fallbackUrl
     * @return string
     */
    function storage_image_url($path, $fallbackUrl = null)
    {
        if (!empty($path)) {
            // If it's already a full URL, return as-is
            if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
                return $path;
            }

            // Normalize: remove leading slashes and strip redundant prefixes
            $cleanPath = ltrim(str_replace('\\', '/', $path), '/');

            foreach (['storage/', 'public/storage/', 'public/'] as $prefix) {
                if (str_starts_with($cleanPath, $prefix)) {
                    $cleanPath = substr($cleanPath, strlen($prefix));
                }
            }

            if (!empty($cleanPath)) return storage_file_url($cleanPath);
        }

        // Fallback (local SVG, NOT external picsum)
        if (!empty($fallbackUrl) && !str_contains((string)$fallbackUrl, 'picsum.photos')) {
            return $fallbackUrl;
        }

        // Detect kades vs generic placeholder
        if (!empty($path) && (str_contains($path, 'kepala-desa') || str_contains($path, 'kades'))) {
            return asset('assets/logo/kades-placeholder.svg');
        }

        return asset('assets/logo/cover-placeholder.svg');
    }
}

if (!function_exists('storage_file_url')) {
    /**
     * Get the public application URL for a file stored on the public disk.
     */
    function storage_file_url(?string $path): string
    {
        $cleanPath = ltrim(str_replace('\\', '/', (string) $path), '/');

        foreach (['storage/', 'public/storage/', 'public/'] as $prefix) {
            if (str_starts_with($cleanPath, $prefix)) {
                $cleanPath = substr($cleanPath, strlen($prefix));
            }
        }

        return route('media.serve', ['path' => $cleanPath]);
    }
}


if (!function_exists('log_activity')) {
    /**
     * Record an audit log activity entry for admin staff actions.
     *
     * @param string $action
     * @param string $description
     * @param \App\Models\User|null $user
     * @return void
     */
    function log_activity($action, $description, $user = null)
    {
        try {
            $currentUser = $user ?: auth()->user();
            $userId = $currentUser ? $currentUser->id : null;
            $userName = $currentUser ? $currentUser->name : 'Sistem';
            $ipAddress = request() ? request()->ip() : null;

            \App\Models\ActivityLog::create([
                'user_id' => $userId,
                'user_name' => $userName,
                'action' => strtoupper($action),
                'description' => $description,
                'ip_address' => $ipAddress,
            ]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Failed to record activity log: ' . $e->getMessage());
        }
    }
}
