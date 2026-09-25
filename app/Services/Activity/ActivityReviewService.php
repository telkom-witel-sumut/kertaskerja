<?php

namespace App\Services\Activity;

use App\Models\Activity;
use App\Models\ActivityClassificationReview;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ActivityReviewService
{
    public function review(
        Activity $activity,
        string $decision,
        ?int $activityEntityId
    ): void {
        DB::transaction(function () use ($activity, $decision, $activityEntityId) {
            $activity->refresh();

            if ($activity->classification_status !== 'review_required') {
                throw ValidationException::withMessages([
                    'review' => 'Activity ini tidak sedang membutuhkan review.',
                ]);
            }

            $selectedEntity = null;

            if ($decision === 'selected') {
                $selectedEntity = $activity->activityEntities()
                    ->whereKey($activityEntityId)
                    ->first();

                if (!$selectedEntity) {
                    throw ValidationException::withMessages([
                        'activity_entity_id' =>
                            'Candidate classification tidak valid untuk activity ini.',
                    ]);
                }
            }

            ActivityClassificationReview::updateOrCreate(
                [
                    'activity_id' => $activity->id,
                ],
                [
                    'selected_activity_entity_id' =>
                        $selectedEntity?->id,

                    'decision' => $decision,

                    'reviewed_by' =>
                        auth()->id()
                        ? (string) auth()->id()
                        : null,

                    'reviewed_at' => now(),
                ]
            );

            $activity->update([
                'classification_status' =>
                    $decision === 'selected'
                    ? 'classified'
                    : 'no_match',
            ]);
        });
    }
}