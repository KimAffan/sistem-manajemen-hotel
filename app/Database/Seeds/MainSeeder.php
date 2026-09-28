<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        echo "\n=== SEEDING DATA TEST ===\n\n";

        $this->call('GuestSeeder');
        $this->call('ReservationSeeder');
        $this->call('HousekeepingSeeder');
        $this->call('SupplierSeeder');
        $this->call('SrSeeder');

        echo "\n=== SEEDING COMPLETE ===\n";
    }
}