<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::table('activities', function (Blueprint $table) {
            $table->enum('classification_status', [
                'pending',
                'processing',
                'classified',
                'review_required',
                'no_match',
                'failed',
            ])->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('activities', function (Blueprint $table) {
            $table->enum('classification_status', [
                'pending',
                'classified',
                'review_required',
                'unclassified',
                'failed',
            ])->default('pending')->change();
        });
    }
};
