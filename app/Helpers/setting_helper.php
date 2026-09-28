<?php

use App\Models\AppSettingModel;

if (! function_exists('app_setting')) {
    /**
     * Ambil nilai setting dari database (dengan cache in-memory)
     * 
     * CATATAN: nama fungsi sengaja "app_setting" untuk menghindari konflik
     * dengan helper "setting()" milik CodeIgniter Shield.
     */
    function app_setting(string $key, $default = null)
    {
        static $cache = null;

        if ($cache === null) {
            try {
                $model = new AppSettingModel();
                $cache = $model->getAllKeyed();
            } catch (\Exception $e) {
                $cache = [];
            }
        }

        return $cache[$key] ?? $default;
    }
}