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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade'); // Связь с курсом
            $table->string('title'); // Название урока
            $table->text('description')->nullable(); // Описание урока
            $table->string('video_url'); // Ссылка на видеоурок (Rutube)
            $table->string('materials_file')->nullable(); // Файл с методическими материалами (PDF)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
