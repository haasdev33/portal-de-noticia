<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';
    protected $fillable = ['key', 'value', 'type', 'label', 'description'];
    public $timestamps = true;

    /**
     * Obter valor de uma configuração
     */
    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Atualizar valor de uma configuração
     */
    public static function set($key, $value)
    {
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    /**
     * Obter todas as configurações como array associativo
     */
    public static function allAsArray()
    {
        return self::pluck('value', 'key')->toArray();
    }
}
