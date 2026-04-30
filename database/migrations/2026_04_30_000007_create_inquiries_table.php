<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained('clients')->nullOnDelete();
            $table->foreignId('watch_id')->nullable()->constrained('watches')->nullOnDelete();
            $table->enum('inquiry_type', ['specific_watch', 'general', 'authentication_pricing'])->default('general');
            $table->enum('status', ['pending', 'responded', 'converted_to_sale', 'no_sale'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('client_id');
            $table->index('watch_id');
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
