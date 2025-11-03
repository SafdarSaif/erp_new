<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        $tables = DB::select('SHOW TABLES');
        $dbName = DB::getDatabaseName();
        $key = 'Tables_in_' . $dbName;

        // Tables to skip
        $excluded = [
            'migrations', 'cache', 'cache_locks',
            'jobs', 'failed_jobs', 'personal_access_tokens',
            'password_reset_tokens', 'role_has_permissions',
            'model_has_permissions', 'model_has_roles',
        ];

        foreach ($tables as $table) {
            $tableName = $table->$key;

            if (in_array($tableName, $excluded)) {
                continue;
            }

            // Skip tables that don't have 'id' column
            if (!Schema::hasColumn($tableName, 'id')) {
                continue;
            }

            if (!Schema::hasColumn($tableName, 'added_by')) {
                Schema::table($tableName, function ($t) use ($tableName) {
                    $t->unsignedBigInteger('added_by')->nullable()->after('id');
                });
                echo "✅ added_by added to {$tableName}\n";
            }
        }
    }

    public function down(): void
    {
        $tables = DB::select('SHOW TABLES');
        $dbName = DB::getDatabaseName();
        $key = 'Tables_in_' . $dbName;

        foreach ($tables as $table) {
            $tableName = $table->$key;

            if (Schema::hasColumn($tableName, 'added_by')) {
                Schema::table($tableName, function ($t) {
                    $t->dropColumn('added_by');
                });
                echo "❌ removed added_by from {$tableName}\n";
            }
        }
    }
};
