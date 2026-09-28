<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');
        $db    = \Config\Database::connect();

        echo "Generating 15 suppliers...\n";

        $companySuffixes = ['Jaya', 'Abadi', 'Sejahtera', 'Makmur', 'Sentosa', 'Prima', 'Utama', 'Bersama'];

        for ($i = 0; $i < 15; $i++) {
            $db->table('suppliers')->insert([
                'name'           => 'PT ' . $faker->company() . ' ' . $faker->randomElement($companySuffixes),
                'contact_person' => $faker->name(),
                'phone'          => $faker->phoneNumber(),
                'email'          => $faker->companyEmail(),
                'address'        => $faker->address(),
                'created_at'     => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ]);
        }

        echo "✓ 15 suppliers created\n";
    }
}