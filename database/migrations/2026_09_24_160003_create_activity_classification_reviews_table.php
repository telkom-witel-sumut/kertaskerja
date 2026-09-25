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
        Schema::create('activity_classification_reviews', function (Blueprint $table) {
            $table->id();

            $table->foreignId('activity_id')
                ->unique()
                ->constrained('activities')
                ->cascadeOnDelete();

            $table->foreignId('selected_activity_entity_id')
                ->nullable()
                ->constrained('activity_entities')
                ->nullOnDelete();

            $table->string('decision', 30); // selected | no_match
            $table->string('reviewed_by')->nullable();
            $table->timestamp('reviewed_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_classification_reviews');
    }
};
