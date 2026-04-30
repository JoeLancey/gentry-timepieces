<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('consignments', function (Blueprint $table) {
            $table->boolean('commission_paid')->default(false)->after('notes');
            $table->timestamp('commission_paid_at')->nullable()->after('commission_paid');
        });
    }

    public function down(): void
    {
        Schema::table('consignments', function (Blueprint $table) {
            $table->dropColumn(['commission_paid', 'commission_paid_at']);
        });
    }
};
