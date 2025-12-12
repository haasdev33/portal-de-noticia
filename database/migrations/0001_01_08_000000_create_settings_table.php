<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string'); // string, color, image, json
            $table->string('label')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Insert default settings
        \DB::table('settings')->insert([
            // Site Info
            ['key' => 'site_name', 'value' => 'Portal de Notícias', 'type' => 'string', 'label' => 'Nome do Site', 'description' => 'Nome exibido em todo o site'],
            ['key' => 'site_tagline', 'value' => 'Notícias, análises e opinião', 'type' => 'string', 'label' => 'Tagline', 'description' => 'Subtítulo do site'],
            ['key' => 'site_logo', 'value' => null, 'type' => 'image', 'label' => 'Logo', 'description' => 'Logo do site (recomendado: 200x60px)'],
            
            // Colors
            ['key' => 'primary_color', 'value' => '#0d6efd', 'type' => 'color', 'label' => 'Cor Primária', 'description' => 'Cor principal dos menus e botões'],
            ['key' => 'secondary_color', 'value' => '#6c757d', 'type' => 'color', 'label' => 'Cor Secundária', 'description' => 'Cor secundária'],
            ['key' => 'navbar_bg_color', 'value' => '#ffffff', 'type' => 'color', 'label' => 'Cor Fundo Navbar', 'description' => 'Cor de fundo da barra de navegação'],
            ['key' => 'navbar_text_color', 'value' => '#000000', 'type' => 'color', 'label' => 'Cor Texto Navbar', 'description' => 'Cor do texto na navbar'],
            ['key' => 'footer_bg_color', 'value' => '#212529', 'type' => 'color', 'label' => 'Cor Fundo Rodapé', 'description' => 'Cor de fundo do rodapé'],
            ['key' => 'footer_text_color', 'value' => '#ffffff', 'type' => 'color', 'label' => 'Cor Texto Rodapé', 'description' => 'Cor do texto no rodapé'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
