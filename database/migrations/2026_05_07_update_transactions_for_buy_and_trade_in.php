<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE transactions MODIFY type ENUM('sale', 'buy', 'trade_in') NOT NULL");

        Schema::table('transactions', function (Blueprint $table) {
            $table->enum('trade_in_cash_from', ['company', 'client'])->nullable()->after('trade_in_appraisal_value');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('trade_in_cash_from');
        });

        DB::statement("ALTER TABLE transactions MODIFY type ENUM('sale', 'trade_in') NOT NULL");
    }
};