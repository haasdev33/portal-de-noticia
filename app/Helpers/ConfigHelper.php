<?php

namespace App\Helpers;

use App\Models\Setting;

class ConfigHelper
{
    /**
     * Obter valor de configuração
     */
    public static function get($key, $default = null)
    {
        static $cache = null;
        
        if ($cache === null) {
            try {
                $cache = Setting::pluck('value', 'key')->toArray();
            } catch (\Exception $e) {
                return $default;
            }
        }
        
        return $cache[$key] ?? $default;
    }

    /**
     * Obter nome do site
     */
    public static function siteName()
    {
        return self::get('site_name', 'Portal de Notícias');
    }

    /**
     * Obter tagline do site
     */
    public static function siteTagline()
    {
        return self::get('site_tagline', 'Notícias, análises e opinião');
    }

    /**
     * Obter logo do site
     */
    public static function siteLogo()
    {
        $logo = self::get('site_logo');
        return $logo ? asset('storage/' . $logo) : null;
    }

    /**
     * Obter cores dinâmicas como CSS variables
     */
    public static function dynamicCss()
    {
        return sprintf(
            ':root { --primary-color: %s; --secondary-color: %s; --navbar-bg: %s; --navbar-text: %s; --footer-bg: %s; --footer-text: %s; }',
            self::get('primary_color', '#0d6efd'),
            self::get('secondary_color', '#6c757d'),
            self::get('navbar_bg_color', '#ffffff'),
            self::get('navbar_text_color', '#000000'),
            self::get('footer_bg_color', '#212529'),
            self::get('footer_text_color', '#ffffff')
        );
    }

    /**
     * Obter objeto de configurações dinâmicas
     */
    public static function getColors()
    {
        return [
            'primary' => self::get('primary_color', '#0d6efd'),
            'secondary' => self::get('secondary_color', '#6c757d'),
            'navbar_bg' => self::get('navbar_bg_color', '#ffffff'),
            'navbar_text' => self::get('navbar_text_color', '#000000'),
            'footer_bg' => self::get('footer_bg_color', '#212529'),
            'footer_text' => self::get('footer_text_color', '#ffffff'),
        ];
    }
}
