<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('appraisal_snapshots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('appraisal_id')->index();
            $table->decimal('appraised_value', 12, 2)->nullable();
            $table->json('changes')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('appraisal_id')->references('id')->on('appraisals')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('appraisal_snapshots');
    }
};
