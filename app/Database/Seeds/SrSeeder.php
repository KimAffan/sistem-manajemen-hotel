<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class SrSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');
        $db    = \Config\Database::connect();

        $items = $db->table('items')->select('id, current_stock')->get()->getResultArray();

        if (empty($items)) {
            echo "⚠ No items, skip SR seeder.\n";
            return;
        }

        echo "Generating 40 store requisitions...\n";

        $departments = ['housekeeping', 'kitchen', 'fb', 'engineering', 'front_office'];
        $statuses    = ['pending', 'approved', 'delivered', 'delivered', 'rejected'];

        for ($i = 0; $i < 40; $i++) {
            $department = $faker->randomElement($departments);
            $status     = $faker->randomElement($statuses);
            $date       = $faker->dateTimeBetween('-3 months', 'now');
            $code       = 'SR-' . $date->format('Ymd') . '-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT);
            $approvedBy = in_array($status, ['approved', 'delivered', 'rejected']) ? 2 : null;
            $approvedDate = in_array($status, ['approved', 'delivered', 'rejected']) ? $date->format('Y-m-d') : null;

            $db->table('store_requisitions')->insert([
                'sr_number'      => $code,
                'department'     => $department,
                'requested_by'   => 2,
                'status'         => $status,
                'requested_date' => $date->format('Y-m-d'),
                'approved_by'    => $approvedBy,
                'approved_date'  => $approvedDate,
                'notes'          => $faker->optional(0.4)->sentence(),
                'created_at'     => $date->format('Y-m-d H:i:s'),
                'updated_at'     => $date->format('Y-m-d H:i:s'),
            ]);
            $srId = $db->insertID();

            // Add 1-4 items per SR
            $numItems = $faker->numberBetween(1, 4);
            $usedItems = [];
            for ($j = 0; $j < $numItems; $j++) {
                $item = $faker->randomElement($items);
                if (in_array($item['id'], $usedItems)) continue;
                $usedItems[] = $item['id'];

                $qtyReq = $faker->numberBetween(5, 30);
                $qtyApp = $status === 'rejected' ? 0 : $faker->numberBetween(1, $qtyReq);

                $db->table('sr_details')->insert([
                    'sr_id'              => $srId,
                    'item_id'            => $item['id'],
                    'quantity_requested' => $qtyReq,
                    'quantity_approved'  => $qtyApp,
                    'created_at'         => $date->format('Y-m-d H:i:s'),
                ]);
            }
        }

        echo "✓ 40 store requisitions created\n";
    }
}