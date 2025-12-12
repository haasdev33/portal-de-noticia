<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Mostrar página de configurações
     */
    public function index()
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Acesso negado');
        }
        
        $settings = Setting::query()->get()->keyBy('key');
        
        return view('admin.settings', ['settings' => $settings]);
    }

    /**
     * Atualizar configurações
     */
    public function update(Request $request)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Acesso negado');
        }
        
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_tagline' => 'nullable|string|max:255',
            'site_logo' => 'nullable|image|max:2048',
            'primary_color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'secondary_color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'navbar_bg_color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'navbar_text_color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'footer_bg_color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'footer_text_color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            // Business / Contact settings
            'business_name' => 'nullable|string|max:255',
            'business_email' => 'nullable|email|max:255',
            'business_phone' => 'nullable|string|max:50',
            'business_address' => 'nullable|string|max:255',
            'business_hours_html' => 'nullable|string',
            'business_map_embed' => 'nullable|string',
            'business_facebook' => 'nullable|url|max:255',
            'business_instagram' => 'nullable|url|max:255',
            'business_twitter' => 'nullable|url|max:255',
            'business_linkedin' => 'nullable|url|max:255',
            'contact_faq_html' => 'nullable|string',
        ]);

        // Handle logo upload
        if ($request->hasFile('site_logo')) {
            $path = $request->file('site_logo')->store('logo', 'public');
            $validated['site_logo'] = $path;
        }

        // Update settings
        foreach ($validated as $key => $value) {
            if ($key === 'site_logo' && !$request->hasFile('site_logo')) {
                continue;
            }
            Setting::set($key, $value);
        }

        return redirect()->route('admin.settings')
            ->with('success', 'Configurações atualizadas com sucesso!');
    }
}
