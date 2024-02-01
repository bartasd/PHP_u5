<?php
// php artisan db:seed --class=ClientSeeder
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ClientSeeder extends Seeder
{
    public function run(): void
    {

        $faker = Faker::create('lt_LT');

        for($i = 0; $i < 80; $i++){
            DB::table('clients')->insert([
                'name' => $faker->firstName,
                'surname' => $faker->lastName,
                'id_code' => mt_rand(31001010000, 62401310000),
            ]); 
        }
    }
}
