<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            if (! Schema::hasColumn('pages', 'show_in_menu')) {
                $table->boolean('show_in_menu')->default(false)->after('video_url');
            }
        });
    }

    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            if (Schema::hasColumn('pages', 'show_in_menu')) {
                $table->dropColumn('show_in_menu');
            }
        });
    }
};
