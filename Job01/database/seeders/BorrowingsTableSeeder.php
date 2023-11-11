<?php

namespace Database\Seeders;

use App\Models\Borrowing;
use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class BorrowingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('borrowings')->delete();
        $book_ids = Book::all()->pluck('BookID')->toArray();
        $faker = Faker::create();
        for ($i = 0; $i < 200; $i++) {
            $borrowDate = $faker->dateTimeBetween('-3 years', 'now');
            $DueDate = $faker->dateTimeBetween($borrowDate, '+1 years');
            Borrowing::create([
                'BookID' => $faker->randomElement($book_ids),
                'MemberID' => $faker->numberBetween(1, 100),
                'BorrowDate' => $borrowDate,
                'DueDate' => $DueDate,
                'ReturnedDate' => $faker->dateTimeBetween($borrowDate, $DueDate),
            ]);
        }
    }
}
