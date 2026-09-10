<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::table('activity_entities', function (Blueprint $table) {
        $table->foreignId('category_id')
            ->after('activity_id')
            ->constrained('entity_categories')
            ->restrictOnDelete();

        $table->foreignId('entity_id')
            ->nullable()
            ->change();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('activity_entities', function (Blueprint $table) {
        $table->dropForeign(['category_id']);
        $table->dropColumn('category_id');

        $table->foreignId('entity_id')
            ->nullable(false)
            ->change();
    });
    }
};
