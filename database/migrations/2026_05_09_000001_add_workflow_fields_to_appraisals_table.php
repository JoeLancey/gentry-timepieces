<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appraisals', function (Blueprint $table) {
            $table->string('workflow_status')->default('pending')->after('status');
            $table->text('review_notes')->nullable()->after('condition_notes');
        });

        DB::table('appraisals')->update([
            'workflow_status' => DB::raw('status'),
        ]);
    }

    public function down(): void
    {
        Schema::table('appraisals', function (Blueprint $table) {
            $table->dropColumn(['workflow_status', 'review_notes']);
        });
    }
};