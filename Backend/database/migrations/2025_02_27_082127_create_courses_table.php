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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('category');
            $table->string('language');
            $table->boolean('certificate')->default(false);
            $table->json('what_you_learn');

            $table->decimal('price', 10, 2)->default(0.00);
            $table->decimal('discount', 10, 2)->nullable()->default(0.00);
            $table->date('discount_ends_at')->nullable();

            $table->string('thumbnail');
            $table->integer('duration')->nullable();
            $table->enum('level', ['Beginner', 'Intermediate', 'Advanced']);
            $table->boolean('publish')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
