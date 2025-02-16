<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

    // 10人分のユーザーを生成
    for ($i = 0; $i < 10; $i++) {
        User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password'), // すべてのユーザーに「password」で設定
                'post_code' => $faker->postcode,
                'address' => $faker->address,
                'building' => $faker->secondaryAddress,
            ]);
        }
    }
}
