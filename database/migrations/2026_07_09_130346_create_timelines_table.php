<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('timelines', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->integer('year');
            $table->enum('type', ['novel', 'comic', 'game', 'movie', 'general'])->default('general');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('character_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('planet_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('timelines');
    }
};
