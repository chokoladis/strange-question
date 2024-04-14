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
        Schema::create('comment_user_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comment_id');
            $table->index('comment_id', 'comment_user_statuses_comment_idx');
            $table->foreign('comment_id', 'comment_user_statuses_comments_fk')->references('id')->on('comments')->cascadeOnDelete();

            $table->unsignedBigInteger('user_id');
            $table->index('user_id', 'comment_user_statuses_user_idx');
            $table->foreign('user_id', 'comment_user_statuses_user_fk')->references('id')->on('users')->cascadeOnDelete();

            $table->string('status', 7);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment_user_statuses');
    }
};
