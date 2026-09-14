<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackupStorageCommand extends Command
{
    protected $signature = 'app:backup-storage';

    protected $description = 'Create a simple backup archive of the public storage directory.';

    public function handle(): int
    {
        $source = storage_path('app/public');
        $backupDir = storage_path('backups');

        if (! is_dir($source)) {
            $this->error('Storage directory does not exist.');
            return self::FAILURE;
        }

        if (! is_dir($backupDir)) {
            mkdir($backupDir, 0777, true);
        }

        $archivePath = $backupDir.'/storage-backup-'.date('Y-m-d-H-i-s').'.tar.gz';

        $command = sprintf(
            'tar -czf "%s" -C "%s" .',
            str_replace('\\', '/', $archivePath),
            str_replace('\\', '/', dirname($source))
        );

        exec($command, $output, $status);

        if ($status !== 0 || ! file_exists($archivePath)) {
            $this->error('Failed to create storage backup archive.');
            return self::FAILURE;
        }

        $this->info('Backup created: '.$archivePath);

        return self::SUCCESS;
    }
}
