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
        Schema::create('user_friends', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('friend_id');
            $table->tinyInteger('accepted')->nullable();
            $table->datetime('accepted_at')->nullable();

            $table->unique(['user_id', 'friend_id']);

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('friend_id')
                ->references('id')
                ->on('users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_friends');
    }
};
