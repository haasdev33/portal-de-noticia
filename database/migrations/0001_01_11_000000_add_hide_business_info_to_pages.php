<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            if (! Schema::hasColumn('pages', 'hide_business_info')) {
                $table->boolean('hide_business_info')->default(false)->after('show_in_menu');
            }
        });
    }

    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            if (Schema::hasColumn('pages', 'hide_business_info')) {
                $table->dropColumn('hide_business_info');
            }
        });
    }
};
