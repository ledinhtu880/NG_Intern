<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('books')->delete();
        $faker = Faker::create();
        for ($i = 0; $i < 20; $i++) {
            Book::create([
                'Title' => $faker->words(2, true),
                'Author' => $faker->name,
                'ISBN' => $faker->ean13(),
                'PublishedYear' => $faker->numberBetween('1988', '2023'),
                'Genre' => $faker->words(1, true),
            ]);
        }
    }
}
