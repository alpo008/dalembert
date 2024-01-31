<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (! Storage::exists('backup')) {
            Storage::makeDirectory('backup');
        }
        collect(Storage::listContents('backup', true))->each(function($file) {
            if ($file['type'] === 'file' && $file['lastModified'] < now()->subDays(5)->getTimestamp()) {
                Storage::delete($file['path']);
            }
        });
 
        $filename = "backup-" . Carbon::now()->format('Y-m-d') . ".sql";
    
        $command = "mysqldump -u" . env('DB_USERNAME') ." -p" . env('DB_PASSWORD') . " " 
        . env('DB_DATABASE') . " > " . storage_path() . "/app/backup/" . $filename;
 
        $returnVar = NULL;
        $output  = NULL;
 
        exec($command, $output, $returnVar);
        return Command::SUCCESS;
    }
}