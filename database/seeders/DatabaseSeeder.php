<?php

namespace Database\Seeders;

use App\Models\Tasks;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Category
        $categories = ['Pekerjaan', 'Pribadi', 'Lainnya'];
        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }

        // Tasks
        $tasks = [
            [
                'content' => "Ngopi Ngopi",
                'details' => "Di Rumah Nopal",
                'priority' => 1,
                'due_date' => now()->format('Y-m-d'),
                'category_id' => 2,
            ],
            [
                'content' => "Ngitung Angka",
                'details' => "2 + 10 = ???\n2 + 8 = ???\n(Incorrect Answer Only)",
                'priority' => 1,
                'due_date' => now()->format('Y-m-d'),
                'category_id' => 2,
                'completed' => true
            ],
            [
                'content' => "Ngasih Susu Buat Ibu Kucing (Yg lagi Hamil)",
                'details' => "Pake H₂SO₄",
                'priority' => 1,
                'due_date' => now()->addDays(-2)->format('Y-m-d'),
                'category_id' => 1,
                'completed' => true
            ],
            [
                'content' => "Menyapu Halaman",
                'details' => "Di Depan Rumah YGY",
                'priority' => 1,
                'due_date' => now()->addDays(1)->format('Y-m-d'),
                'category_id' => 1,
            ],
            [
                'content' => "Main Ke Rumah Padil",
                'details' => "Daripada Sendirian yakan",
                'priority' => 2,
                'due_date' => now()->addDays(2)->format('Y-m-d'),
                'category_id' => 2,
            ],
            [
                'content' => "Main Fesnuk",
                'details' => "Fesnuk Teroosss",
                'priority' => 3,
                'due_date' => now()->addDays(3)->format('Y-m-d'),
                'category_id' => 3,
            ]
        ];

        foreach ($tasks as $task) {
            Tasks::create($task);
        }
    }
}
