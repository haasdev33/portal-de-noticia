<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            if (! Schema::hasColumn('pages', 'thumbnail')) {
                $table->string('thumbnail')->nullable()->after('content');
            }
            if (! Schema::hasColumn('pages', 'video_url')) {
                $table->string('video_url')->nullable()->after('thumbnail');
            }
        });
    }

    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            if (Schema::hasColumn('pages', 'video_url')) {
                $table->dropColumn('video_url');
            }
            if (Schema::hasColumn('pages', 'thumbnail')) {
                $table->dropColumn('thumbnail');
            }
        });
    }
};
