<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreignId('trade_in_watch_id')->nullable()->constrained('watches')->nullOnDelete()->after('watch_id');
            $table->decimal('trade_in_appraisal_value', 12, 2)->nullable()->after('amount');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeignKeyConstraints();
            $table->dropColumn(['trade_in_watch_id', 'trade_in_appraisal_value']);
        });
    }
};
