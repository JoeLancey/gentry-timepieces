<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('watch_status_log', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('watch_id')->index();
            $table->string('from_status')->nullable();
            $table->string('to_status');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->foreign('watch_id')->references('id')->on('watches')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('watch_status_log');
    }
};
