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
        Schema::create('user_comments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('comment_id');

            $table->index('user_id', 'user_comments_user_idx');
            $table->index('comment_id', 'user_comments_comment_idx');

            $table->foreign('user_id', 'user_comments_user_fk')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('comment_id', 'user_comments_comment_fk')->references('id')->on('comments')->cascadeOnDelete();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_comments');
    }
};
