<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class CreateTestDatabase extends Command
{
    protected $signature = 'db:create-test-database';
    protected $description = 'Create the test database if it does not exist';

    public function handle()
    {
        $database = env('DB_DATABASE_TEST');

        // Проверяем существует ли база данных
        $dbExists = DB::select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?", [$database]);

        if (empty($dbExists)) {
            // Если базы данных нет, создаем её
            DB::statement("CREATE DATABASE $database");

            $this->info("Database $database created successfully!");
        } else {
            $this->info("Database $database already exists.");
        }

        Artisan::call('migrate:fresh', ['--database' => 'mysql_test']);
        $this->info("Migrations completed successfully!");
    }
}
