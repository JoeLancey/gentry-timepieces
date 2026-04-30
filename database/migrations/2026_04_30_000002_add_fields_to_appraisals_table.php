<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appraisals', function (Blueprint $table) {
            $table->timestamp('completed_at')->nullable()->after('status');
            $table->enum('authenticity_conclusion', ['authentic', 'counterfeit', 'suspected_counterfeit', 'inconclusive'])->nullable()->after('completed_at');
            $table->enum('documentation_quality', ['complete', 'incomplete', 'missing_papers', 'missing_box'])->nullable()->after('authenticity_conclusion');
        });
    }

    public function down(): void
    {
        Schema::table('appraisals', function (Blueprint $table) {
            $table->dropColumn(['completed_at', 'authenticity_conclusion', 'documentation_quality']);
        });
    }
};
