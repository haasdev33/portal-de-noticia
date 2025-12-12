<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['slug','title','content','thumbnail','video_url','show_in_menu','hide_business_info'];

    public function images()
    {
        return $this->hasMany(PageImage::class)->orderBy('position');
    }

    /**
     * Render page content supporting simple shortcodes replaced by Blade includes.
     * Example shortcodes: [[contact_form]], [[business_info]], [[map]]
     */
    public function renderContent()
    {
        $content = $this->content ?? '';

        // Map shortcodes to blade includes
        $map = [
            '/\[\[contact_form\]\]/' => "@include('page-components.contact_form')",
            '/\[\[business_info\]\]/' => "@include('page-components.business_info')",
            '/\[\[map\]\]/' => "@include('page-components.map')",
        ];

        $replaced = preg_replace(array_keys($map), array_values($map), $content);

        try {
            return \Blade::render($replaced, ['page' => $this]);
        } catch (\Throwable $e) {
            // Fallback: return raw content if Blade render fails
            return $replaced;
        }
    }
}
