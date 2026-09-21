<?php

namespace App\Services\Activity;

use App\Models\Activity;

class ActivityClassificationService
{
    public function __construct(
        private PythonClassifierService $pythonClassifier,
        private ClassificationResultService $resultProcessor,
    ) {
    }

    public function classify(Activity $activity): Activity
    {
        $response = $this->pythonClassifier->classify(
            $activity->id,
            $activity->activity_notes
        );

        return $this->resultProcessor->process($response);
    }
}