<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->string('planet')->nullable();
            $table->year('birth_year')->nullable();
            $table->year('death_year')->nullable();
            $table->string('race')->nullable();
            $table->string('gender')->nullable();
            $table->text('description')->nullable();
            $table->json('quotes')->nullable(); // Массив цитат
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('characters');
        Schema::table('characters', function (Blueprint $table) {
            $table->dropColumn('alias');
            $table->dropColumn('lightsaber_color');
        });
    }
};
