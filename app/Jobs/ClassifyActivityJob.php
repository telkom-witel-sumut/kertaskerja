<?php

namespace App\Jobs;

use App\Models\Activity;
use App\Services\Activity\ActivityClassificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class ClassifyActivityJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public array $backoff = [10, 30, 60];

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

        if (
            in_array($activity->classification_status, [
                'classified',
                'review_required',
                'no_match',
            ], true)
        ) {
            return;
        }

        $activity->update([
            'classification_status' => 'processing',
        ]);

        $classificationService->classify($activity);
    }

    public function failed(Throwable $exception): void
    {
        Activity::whereKey($this->activityId)->update([
            'classification_status' => 'failed',
        ]);
    }
}