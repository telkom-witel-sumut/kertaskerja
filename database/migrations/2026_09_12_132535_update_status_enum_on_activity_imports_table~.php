<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE activity_imports
            MODIFY status ENUM(
                'uploaded',
                'processing',
                'preview',
                'confirmed',
                'failed',
                'cancelled'
            ) NOT NULL DEFAULT 'uploaded'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE activity_imports
            MODIFY status ENUM(
                'uploaded',
                'processing',
                'completed',
                'failed'
            ) NOT NULL DEFAULT 'uploaded'
        ");
    }
};