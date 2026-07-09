<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('timeline', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type', ['novel', 'comic', 'movie', 'game', 'other'])->default('novel');
            $table->year('year_start');
            $table->year('year_end')->nullable();
            $table->string('era')->nullable(); // Старая Республика, Империя, Новая Республика и т.д.
            $table->string('author')->nullable();
            $table->string('publisher')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('timeline');
    }
};
