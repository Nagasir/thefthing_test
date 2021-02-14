<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for($i = 1; $i <= 50; $i++){

            // insert data ke table pegawai menggunakan Faker
            DB::table('customers')->insert([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => \Illuminate\Support\Facades\Hash::make($faker->password),
                'gender' => $faker->randomElement(['Male', 'Female']),
                'is_married' => $faker->boolean(40),
                'address' => $faker->address
            ]);

        }
    }
}
