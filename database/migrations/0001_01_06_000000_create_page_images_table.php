<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('page_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained('pages')->cascadeOnDelete();
            $table->string('path');
            $table->integer('position')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('page_images');
    }
};
