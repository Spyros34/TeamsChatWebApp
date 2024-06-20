<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DropAllTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:drop-all-tables';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop all tables from the database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Disable foreign key constraints
        DB::statement('EXEC sp_MSforeachtable @command1="ALTER TABLE ? NOCHECK CONSTRAINT all"');

        $tables = DB::select('SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = \'BASE TABLE\' AND TABLE_CATALOG = DB_NAME()');

        foreach ($tables as $table) {
            $tableName = $table->TABLE_NAME;
            DB::statement("DROP TABLE [$tableName]");
        }

        // Enable foreign key constraints
        DB::statement('EXEC sp_MSforeachtable @command1="ALTER TABLE ? CHECK CONSTRAINT all"');

        $this->info('All tables dropped successfully.');
        return 0;
    }
}