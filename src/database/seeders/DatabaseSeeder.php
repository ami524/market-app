<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // シーダーを実行
        $this->call([
            CategorySeeder::class,
            UserSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
