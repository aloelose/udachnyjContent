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
        Schema::create('children', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Связь с пользователем (родителем)
            $table->string('full_name'); // ФИО ребёнка
            $table->integer('age'); // Возраст ребёнка
            $table->enum('status', ['Ребёнок-инвалид', 'Ребёнок с ОВЗ']); // Статус ребёнка
            $table->string('pmpk_code')->nullable(); // Шифр по ПМПК
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('children');
    }
};
