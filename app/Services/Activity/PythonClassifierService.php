<?php

namespace App\Services\Activity;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class PythonClassifierService
{
    public function classify(int $activityId, string $activityNotes): array
    {
        $response = Http::withToken(
            config('services.python_classifier.api_key')
        )
            ->acceptJson()
            ->timeout(30)
            ->post(
                rtrim(config('services.python_classifier.url'), '/') . '/api/classifier-py',
                [
                    'id' => $activityId,
                    'activity_notes' => $activityNotes,
                ]
            );

        if ($response->failed()) {
            throw new RuntimeException(
                "Python classifier request failed with status {$response->status()}."
            );
        }

        $data = $response->json();

        if (!is_array($data)) {
            throw new RuntimeException(
                'Python classifier returned an invalid JSON response.'
            );
        }

        return $data;
    }
}