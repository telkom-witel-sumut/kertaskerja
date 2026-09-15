<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
      public function up(): void
    {
        Schema::create('activity_entities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('activity_id')
                ->constrained('activities')
                ->cascadeOnDelete();

            $table->foreignId('entity_id')
                ->constrained('entities')
                ->restrictOnDelete();

          
            $table->decimal('match_score', 5, 4)->nullable();

            $table->string('match_method')->nullable();

            $table->timestamps();

            $table->unique(
                ['activity_id', 'entity_id'],
                'activity_entities_activity_entity_unique'
            );

            $table->index('activity_id');
            $table->index('entity_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_entities');
    }
};
