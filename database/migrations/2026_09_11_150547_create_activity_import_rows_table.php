<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_import_rows', function (Blueprint $table) {
            $table->id();

            $table->foreignId('import_id')
                ->constrained('activity_imports')
                ->cascadeOnDelete();

            $table->unsignedInteger('source_row');

            $table->string('source_id')->nullable();
            $table->string('nik')->nullable();
            $table->string('name')->nullable();
            $table->string('role')->nullable();
            $table->string('am_type')->nullable();
            $table->string('division')->nullable();
            $table->string('segment')->nullable();
            $table->string('regional')->nullable();
            $table->string('witel')->nullable();
            $table->string('ca_name')->nullable();
            $table->string('nipnas')->nullable();

            $table->dateTime('activity_start_date')->nullable();
            $table->dateTime('activity_end_date')->nullable();
            $table->dateTime('created_at_source')->nullable();

            $table->string('label')->nullable();
            $table->string('activity_type')->nullable();
            $table->longText('activity_notes')->nullable();

            $table->string('validation_status')->default('pending');
            $table->json('validation_errors')->nullable();

            $table->string('classification_status')->default('pending');

            $table->timestamps();

            $table->index(['import_id', 'validation_status']);
            $table->index(['import_id', 'classification_status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_import_rows');
    }
};