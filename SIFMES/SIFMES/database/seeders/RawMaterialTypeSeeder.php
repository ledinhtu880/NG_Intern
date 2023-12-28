<?php

namespace Database\Seeders;

use App\Models\RawMaterialType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;


class RawMaterialTypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('rawMaterialType')->delete();
        $faker = Faker::create();
        for ($i = 0; $i < 5; $i++) {
            RawMaterialType::create([
                'Name_RawMaterialType' => $faker->name,
            ]);
        }
    }
}
