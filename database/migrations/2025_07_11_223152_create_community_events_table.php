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
        Schema::create('community_events', function (Blueprint $table) {

            $table->id();
            $table->foreign('community_id')
                ->on('communities')
                ->references('id')
                ->onDelete('cascade');
            $table->string('title');
            $table->string('link')->nullable();
            $table->text('description');
            $table->date('date_start');
            $table->date('date_end');

            $table->time('time_start');
            $table->time('time_end');
            $table->text('local');
            $table->string('photo')->nullable();

            $table->unsignedBigInteger('community_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_events');
    }
};
