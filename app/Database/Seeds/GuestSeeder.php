<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class GuestSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');
        $db    = \Config\Database::connect();

        echo "Generating 150 guests...\n";

        $data = [];
        for ($i = 0; $i < 150; $i++) {
            $data[] = [
                'full_name'  => $faker->name(),
                'id_number'  => $faker->numerify('################'),
                'phone'      => $faker->phoneNumber(),
                'email'      => $faker->safeEmail(),
                'address'    => $faker->address(),
                'created_at' => $faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        $db->table('guests')->insertBatch($data);
        echo "✓ 150 guests created\n";
    }
}