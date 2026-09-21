<?php

namespace App\Jobs;

use App\Models\Activity;
use App\Services\Activity\ActivityClassificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ClassifyActivityJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $activityId
    ) {
    }

    public function handle(
        ActivityClassificationService $classificationService
    ): void {
        $activity = Activity::find($this->activityId);

        if (!$activity) {
            return;
        }

        $classificationService->classify($activity);
    }
}