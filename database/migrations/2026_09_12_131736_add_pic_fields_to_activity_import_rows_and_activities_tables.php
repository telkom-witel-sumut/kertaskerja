<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activity_import_rows', function (Blueprint $table) {
            $table->string('nama_pic_1')->nullable()->after('activity_notes');
            $table->string('jabatan_pic_1')->nullable()->after('nama_pic_1');
            $table->string('peran_pic_1')->nullable()->after('jabatan_pic_1');
        });

        Schema::table('activities', function (Blueprint $table) {
            $table->string('nama_pic_1')->nullable()->after('activity_notes');
            $table->string('jabatan_pic_1')->nullable()->after('nama_pic_1');
            $table->string('peran_pic_1')->nullable()->after('jabatan_pic_1');
        });
    }

    public function down(): void
    {
        Schema::table('activity_import_rows', function (Blueprint $table) {
            $table->dropColumn([
                'nama_pic_1',
                'jabatan_pic_1',
                'peran_pic_1',
            ]);
        });

        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn([
                'nama_pic_1',
                'jabatan_pic_1',
                'peran_pic_1',
            ]);
        });
    }
};