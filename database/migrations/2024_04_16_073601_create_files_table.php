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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('expansion', 5);
            $table->string('path')->unique();
            $table->string('path_thumbnail')->nullable()->unique();
            $table->string('description')->nullable();
            
            $table->unsignedBigInteger('question_id')->default(null);
            $table->index('question_id', 'files_question_idx');
            $table->foreign('question_id', 'files_question_fk')->references('id')->on('questions')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
