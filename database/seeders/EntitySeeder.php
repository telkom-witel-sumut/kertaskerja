<?php

namespace Database\Seeders;

use App\Models\Entity;
use App\Models\EntityCategory;
use Illuminate\Database\Seeder;

class EntitySeeder extends Seeder
{
    public function run(): void
    {
        // Top-level categories
        $localGov = EntityCategory::firstOrCreate([
            'name' => 'Local Gov',
            'parent_id' => null,
        ], [
            'is_active' => true,
        ]);

        $influencer = EntityCategory::firstOrCreate([
            'name' => 'Influencer',
            'parent_id' => null,
        ], [
            'is_active' => true,
        ]);

        $nonTelkom = EntityCategory::firstOrCreate([
            'name' => 'Non Telkom e-Purchasing Winners',
            'parent_id' => null,
        ], [
            'is_active' => true,
        ]);

        // Subcategories
        $localSi = EntityCategory::firstOrCreate([
            'name' => 'Local SI',
            'parent_id' => $nonTelkom->id,
        ], [
            'is_active' => true,
        ]);

        $nationalSi = EntityCategory::firstOrCreate([
            'name' => 'National SI',
            'parent_id' => $nonTelkom->id,
        ], [
            'is_active' => true,
        ]);

        $nap = EntityCategory::firstOrCreate([
            'name' => 'NAP',
            'parent_id' => $nonTelkom->id,
        ], [
            'is_active' => true,
        ]);

        $operator = EntityCategory::firstOrCreate([
            'name' => 'Operator',
            'parent_id' => $nonTelkom->id,
        ], [
            'is_active' => true,
        ]);

        $this->createEntities($localGov, [
            'Gubsu',
            'Wagubsu',
            'Walikota',
            'Bupati',
            'Wawali',
            'Wabup',
            'Sekda',
            'Asisten',
            'Kabiro',
            'Kadis',
            'Kepala',
            'Ketua',
            'Direktur',
            'Kabid',
            'Kabag',
            'Kasubbag',
            'Sekr',
            'PPK',
        ]);

        $this->createEntities($localSi, [
            'Aneka Signal',
            'Aporas',
            'Artamedia',
            'DDI',
            'DelimaNet',
            'DGS',
            'Digitalku',
            'Giztech',
            'IMS',
            'Inmeet',
            'LDP',
            'Masnet',
            'Mikromax',
            'Newton',
            'Optimus',
            'Rifanta',
            'SKI',
            'TNC',
            'VijjaNet',
            'Whiz',
        ]);

        $this->createEntities($nationalSi, [
            'FiberNet',
            'Infranet',
            'Intek',
            'Nusanet',
            'WizNet',
        ]);

        $this->createEntities($nap, [
            'IconPlus',
            'Iforte',
            'Lintasarta',
            'Moratel',
            'Sanatel',
            'THC',
        ]);

        $this->createEntities($operator, [
            'Indosat',
        ]);

        // Influencer intentionally has no members yet.
    }

    private function createEntities(EntityCategory $category, array $names): void
    {
        foreach ($names as $name) {
            Entity::firstOrCreate(
                [
                    'name' => $name,
                    'category_id' => $category->id,
                ],
                [
                    'is_active' => true,
                ]
            );
        }
    }
}