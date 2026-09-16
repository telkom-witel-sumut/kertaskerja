<?php

namespace App\Services\Activity;

use App\Models\Activity;
use App\Models\ActivityEntity;
use App\Models\Entity;
use App\Models\EntityCategory;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use RuntimeException;

class ClassificationResultService
{
    public function process(array $response): Activity
    {
        $this->validateResponse($response);

        return DB::transaction(function () use ($response) {
            $activity = Activity::query()
                ->lockForUpdate()
                ->find($response['id']);

            if (!$activity) {
                throw new RuntimeException(
                    "Activity dengan ID {$response['id']} tidak ditemukan."
                );
            }

            $status = $response['status'];

            // Hapus hasil classification sebelumnya.
            // Ini membuat proses aman ketika activity diproses ulang.
            $activity->activityEntities()->delete();

            if ($status !== 'no_match') {
                foreach ($response['classifications'] as $classification) {
                    $this->saveClassification(
                        $activity,
                        $classification
                    );
                }
            }

            $activity->update([
                'classification_status' => $this->mapStatus($status),
            ]);

            return $activity->fresh([
                'activityEntities.category',
                'activityEntities.entity',
            ]);
        });
    }

    private function validateResponse(array $response): void
    {
        if (!isset($response['id'])) {
            throw new InvalidArgumentException(
                'Classification response tidak memiliki id.'
            );
        }

        if (!isset($response['status'])) {
            throw new InvalidArgumentException(
                'Classification response tidak memiliki status.'
            );
        }

        $allowedStatuses = [
            'matched',
            'review_required',
            'no_match',
        ];

        if (!in_array($response['status'], $allowedStatuses, true)) {
            throw new InvalidArgumentException(
                "Status classification tidak valid: {$response['status']}"
            );
        }

        if (!isset($response['classifications']) || !is_array($response['classifications'])) {
            throw new InvalidArgumentException(
                'Field classifications harus berupa array.'
            );
        }

        if ($response['status'] !== 'no_match' && empty($response['classifications'])) {
            throw new InvalidArgumentException(
                "Status {$response['status']} membutuhkan minimal satu classification."
            );
        }
    }

    private function saveClassification(
        Activity $activity,
        array $classification
    ): void {
        if (!isset($classification['category'])) {
            throw new InvalidArgumentException(
                'Classification tidak memiliki category.'
            );
        }

        $category = EntityCategory::query()
            ->where('name', $classification['category'])
            ->where('is_active', true)
            ->first();

        if (!$category) {
            throw new RuntimeException(
                "Category aktif tidak ditemukan: {$classification['category']}"
            );
        }

        $entity = null;

        if (
            array_key_exists('entity', $classification)
            && $classification['entity'] !== null
            && trim((string) $classification['entity']) !== ''
        ) {
            $entity = Entity::query()
                ->where('name', $classification['entity'])
                ->where('category_id', $category->id)
                ->where('is_active', true)
                ->first();

            if (!$entity) {
                throw new RuntimeException(
                    "Entity aktif '{$classification['entity']}' " .
                    "tidak ditemukan pada category '{$category->name}'."
                );
            }
        }

        $score = $classification['score'] ?? null;

        if ($score !== null && (!is_numeric($score) || $score < 0 || $score > 1)) {
            throw new InvalidArgumentException(
                "Score classification tidak valid: {$score}"
            );
        }

        $matchMethod = $classification['Match_method'] ?? null;

        $this->createIfNotDuplicate(
            $activity,
            $category,
            $entity,
            $score,
            $matchMethod
        );
    }

    private function createIfNotDuplicate(
        Activity $activity,
        EntityCategory $category,
        ?Entity $entity,
        mixed $score,
        ?string $matchMethod
    ): void {
        $query = ActivityEntity::query()
            ->where('activity_id', $activity->id)
            ->where('category_id', $category->id);

        if ($entity) {
            $query->where('entity_id', $entity->id);
        } else {
            $query->whereNull('entity_id');
        }

        if (!$query->exists()) {
            ActivityEntity::create([
                'activity_id' => $activity->id,
                'category_id' => $category->id,
                'entity_id' => $entity?->id,
                'match_score' => $score,
                'match_method' => $matchMethod,
            ]);
        }
    }

    private function mapStatus(string $status): string
    {
        return match ($status) {
            'matched' => 'classified',
            'review_required' => 'review_required',
            'no_match' => 'no_match',
        };
    }
}