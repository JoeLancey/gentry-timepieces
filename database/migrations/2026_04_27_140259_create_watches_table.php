<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('watches', function (Blueprint $table) {
            $table->id();
            $table->string('brand');
            $table->string('model');
            $table->string('reference_number')->nullable();
            $table->string('serial_number')->unique();
            $table->year('year_produced')->nullable();
            $table->enum('condition', ['mint', 'excellent', 'good', 'fair']);
            $table->boolean('has_box')->default(false);
            $table->boolean('has_papers')->default(false);
            $table->decimal('asking_price', 10, 2);
            $table->decimal('cost_price', 10, 2);
            $table->enum('status', ['available', 'sold', 'consigned', 'reserved'])->default('available');
            $table->string('image_path')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('watches');
    }
};