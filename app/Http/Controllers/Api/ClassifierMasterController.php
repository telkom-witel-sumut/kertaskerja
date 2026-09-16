<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EntityCategory;
use Illuminate\Http\JsonResponse;

class ClassifierMasterController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = EntityCategory::query()
            ->where('is_active', true)
            ->with([
                'entities' => function ($query) {
                    $query->where('is_active', true)
                        ->orderBy('name');
                },
            ])
            ->orderBy('name')
            ->get();

        $data = $categories->flatMap(function ($category) {
            if ($category->entities->isEmpty()) {
                return [[
                    'category' => $category->name,
                    'entity' => null,
                ]];
            }

            return $category->entities->map(function ($entity) use ($category) {
                return [
                    'category' => $category->name,
                    'entity' => $entity->name,
                ];
            });
        })->values();

        return response()->json([
            'data' => $data,
        ]);
    }
}