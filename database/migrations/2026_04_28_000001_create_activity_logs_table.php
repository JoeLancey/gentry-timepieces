<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('action'); // 'created', 'updated', 'deleted', 'restored', 'approved'
            $table->string('model_type'); // 'Watch', 'User', 'Payment', etc.
            $table->unsignedBigInteger('model_id');
            $table->text('changes')->nullable(); // JSON: {field: {old: value, new: value}}
            $table->text('description')->nullable(); // Human-readable description
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
            $table->index(['model_type', 'model_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
