<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StorageBackupCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_storage_backup_command_creates_archive(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('sample.txt', 'hello backup');

        $this->artisan('app:backup-storage')->assertSuccessful();

        $files = glob(storage_path('backups/*.tar.gz'));

        $this->assertNotEmpty($files);
    }
}
