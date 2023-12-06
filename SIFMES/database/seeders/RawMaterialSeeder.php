<?php

namespace Database\Seeders;

use App\Models\RawMaterial;
use App\Models\RawMaterialType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;


class RawMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rawMaterial')->delete();
        $faker = Faker::create();
        $ids = RawMaterialType::all()->pluck('Id_RawMaterialType')->toArray();
        for ($i = 0; $i < 20; $i++) {
            RawMaterial::create([
                'Name_RawMaterial' => $faker->name,
                'Unit' => $faker->words(1, true),
                'count' => $faker->numberBetween(1, 50),
                'FK_Id_RawMaterialType' => $faker->randomElement($ids),
            ]);
        }
    }
}
