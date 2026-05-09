<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== Database Verification ===\n";
echo "Appraisals: " . DB::table('appraisals')->count() . "\n";
echo "Watches: " . DB::table('watches')->count() . "\n";
echo "Users: " . DB::table('users')->count() . "\n";
echo "Clients: " . DB::table('clients')->count() . "\n";
echo "Activity Logs: " . DB::table('activity_logs')->count() . "\n";
echo "\n=== New Tables (Migrations Check) ===\n";
echo "Appraisal Snapshots table exists: " . (DB::connection()->getSchemaBuilder()->hasTable('appraisal_snapshots') ? 'YES' : 'NO') . "\n";
echo "Watch Status Log table exists: " . (DB::connection()->getSchemaBuilder()->hasTable('watch_status_log') ? 'YES' : 'NO') . "\n";
echo "Notifications table exists: " . (DB::connection()->getSchemaBuilder()->hasTable('notifications') ? 'YES' : 'NO') . "\n";
echo "\n=== Sample Data ===\n";
$appraisal = DB::table('appraisals')->first();
if ($appraisal) {
    echo "Sample Appraisal ID: $appraisal->id | Watch ID: $appraisal->watch_id | Status: $appraisal->workflow_status\n";
}
$user = DB::table('users')->where('role', 'admin')->first();
if ($user) {
    echo "Admin User: $user->name ($user->email)\n";
}
