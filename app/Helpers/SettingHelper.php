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
