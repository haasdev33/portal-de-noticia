<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class PreserveRefreshDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:preserve-refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export current users, run migrate:fresh and re-import users';

    public function handle()
    {
        $this->info('Exporting users to storage/app/preserved_users.json');

        $users = DB::table('users')->get()->map(function ($u) {
            return (array) $u;
        })->toArray();

        Storage::put('preserved_users.json', json_encode($users));
        $this->info(count($users) . " users exported.");

        // If using sqlite, create an automatic backup copy before running migrate:fresh
        $defaultConnection = config('database.default');
        $this->info('Default DB connection: ' . $defaultConnection);
        if ($defaultConnection === 'sqlite') {
            $sqlitePath = config('database.connections.sqlite.database');
            if ($sqlitePath && file_exists($sqlitePath)) {
                $backupDir = storage_path('app/db-backups');
                if (! is_dir($backupDir)) mkdir($backupDir, 0755, true);
                $backupFile = $backupDir . '/database-backup-' . date('Ymd-His') . '.sqlite';
                copy($sqlitePath, $backupFile);
                $this->info('SQLite DB backed up to: ' . $backupFile);
            }
        }

        $this->warn('About to run migrate:fresh — THIS WILL DESTROY ALL DATA.');
        if (! $this->confirm('Do you want to continue?')) {
            $this->info('Aborted. No changes made.');
            return 1;
        }

        $this->info('Running migrate:fresh --force');
        Artisan::call('migrate:fresh', ['--force' => true]);
        $this->info(Artisan::output());

        $this->info('Re-importing users from storage/app/preserved_users.json');
        $data = json_decode(Storage::get('preserved_users.json'), true) ?: [];

        foreach ($data as $row) {
            // ensure timestamps are present
            if (! isset($row['created_at'])) $row['created_at'] = now();
            if (! isset($row['updated_at'])) $row['updated_at'] = now();
            DB::table('users')->insert($row);
        }

        $this->info(count($data) . ' users restored.');
        $this->info('Done.');
        return 0;
    }
}
