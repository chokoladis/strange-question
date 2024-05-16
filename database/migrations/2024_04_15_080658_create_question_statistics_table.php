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
        Schema::create('question_statistics', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('question_id');
            $table->index('question_id', 'question_statistics_question_idx');
            $table->foreign('question_id', 'question_statistics_question_fk')->references('id')->on('questions')->cascadeOnDelete();
            
            $table->bigInteger('views')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_statistics');
    }
};
