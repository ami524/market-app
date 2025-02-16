<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\User;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'title' => '腕時計',
                'price' => 15000,
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'item_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
                'item_condition' => 'good',
                'user_id' => User::first()->id,
            ],
            [
                'title' => 'HDD',
                'price' => 5000,
                'description' => '高速で信頼性の高いハードディスク',
                'item_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
                'item_condition' => 'so so',
                'user_id' => User::first()->id,
            ],
            [
                'title' => '玉ねぎ3束',
                'price' => 300,
                'description' => '新鮮な玉ねぎ3束のセット',
                'item_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
                'item_condition' => 'bad',
                'user_id' => User::first()->id,
            ],
            [
                'title' => '革靴',
                'price' => 4000,
                'description' => 'クラシックなデザインの革靴',
                'item_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
                'item_condition' => 'so bad',
                'user_id' => User::first()->id,
            ],
            [
                'title' => 'ノートPC',
                'price' => 45000,
                'description' => '高性能なノートパソコン',
                'item_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
                'item_condition' => 'good',
                'user_id' => User::first()->id,
            ],
            [
                'title' => 'マイク',
                'price' => 8000,
                'description' => '高音質のレコーディング用マイク',
                'item_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
                'item_condition' => 'so so',
                'user_id' => User::first()->id,
            ],
            [
                'title' => 'ショルダーバッグ',
                'price' => 3500,
                'description' => 'おしゃれなショルダーバッグ',
                'item_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
                'item_condition' => 'bad',
                'user_id' => User::first()->id,
            ],
            [
                'title' => 'タンブラー',
                'price' => 500,
                'description' => '使いやすいタンブラー',
                'item_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
                'item_condition' => 'so bad',
                'user_id' => User::first()->id,
            ],
            [
                'title' => 'コーヒーミル',
                'price' => 4000,
                'description' => '手動のコーヒーミル',
                'item_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
                'item_condition' => 'good',
                'user_id' => User::first()->id,
            ],
            [
                'title' => 'メイクセット',
                'price' => 2500,
                'description' => '便利なメイクアップセット',
                'item_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
                'item_condition' => 'so so',
                'user_id' => User::first()->id,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
