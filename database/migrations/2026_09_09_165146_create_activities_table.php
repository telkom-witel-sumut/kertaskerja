<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();

            /*
             * Identitas import yang memasukkan activity ini.
             */
            $table->foreignId('import_id')
                ->constrained('activity_imports')
                ->cascadeOnDelete();

            /*
             * ID dari system/source Excel.
             * Tidak dibuat UNIQUE karena karakteristik source ID
             * belum kita pastikan sepenuhnya.
             */
            $table->string('source_id')->nullable();

            /*
             * Nomor baris asli di Excel.
             * Header = row 1, data pertama = row 2.
             */
            $table->unsignedInteger('source_row')->nullable();

            /*
             * Data activity from Excel.
             */
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

            /*
             * Waktu activity dari source.
             */
            $table->dateTime('activity_start_date')->nullable();
            $table->dateTime('activity_end_date')->nullable();
            $table->dateTime('created_at_source')->nullable();

            $table->string('label')->nullable();
            $table->string('activity_type')->nullable();

            $table->longText('activity_notes')->nullable();

            /*
             * Status klasifikasi activity.
             */
            $table->enum('classification_status', [
                'pending',
                'classified',
                'review_required',
                'unclassified',
                'failed',
            ])->default('pending')->index();

            $table->timestamps();

            /*
             * Index yang kemungkinan besar sering dipakai.
             */
            $table->index('import_id');
            $table->index('source_id');
            $table->index('activity_start_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
