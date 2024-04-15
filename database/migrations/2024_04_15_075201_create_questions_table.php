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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->index('user_id', 'questions_user_idx');
            $table->foreign('user_id', 'questions_user_fk')->references('id')->on('users')->cascadeOnDelete();

            $table->string('title', 255);
            $table->index('title', 'questions_title_idx');
            $table->boolean('active');
            
            $table->unsignedBigInteger('right_comment_id');
            $table->index('right_comment_id', 'questions_right_comment_idx');
            $table->foreign('right_comment_id', 'questions_comment_fk')->references('id')->on('comments')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
