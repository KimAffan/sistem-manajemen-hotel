<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class HousekeepingSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');
        $db    = \Config\Database::connect();

        $rooms  = $db->table('rooms')->select('id')->get()->getResultArray();
        $staffs = $db->table('users')->select('id')->where('active', 1)->get()->getResultArray();

        if (empty($rooms)) {
            echo "⚠ No rooms, skip housekeeping seeder.\n";
            return;
        }

        echo "Generating 60 housekeeping tasks...\n";

        $taskTypes = ['daily_clean', 'checkout_clean', 'deep_clean', 'inspection'];
        $statuses  = ['pending', 'in_progress', 'done', 'verified', 'verified', 'done'];

        for ($i = 0; $i < 60; $i++) {
            $room       = $faker->randomElement($rooms);
            $staff      = $faker->optional(0.7)->randomElement($staffs);
            $taskType   = $faker->randomElement($taskTypes);
            $status     = $faker->randomElement($statuses);
            $createdAt  = $faker->dateTimeBetween('-30 days', 'now');
            $startedAt  = null;
            $completedAt = null;

            if (in_array($status, ['in_progress', 'done', 'verified'])) {
                $startedAt = (clone $createdAt)->modify('+' . $faker->numberBetween(5, 60) . ' minutes');
            }
            if (in_array($status, ['done', 'verified'])) {
                $completedAt = (clone $startedAt)->modify('+' . $faker->numberBetween(20, 120) . ' minutes');
            }

            $db->table('housekeeping_tasks')->insert([
                'room_id'      => $room['id'],
                'assigned_to'  => $staff ? $staff['id'] : null,
                'task_type'    => $taskType,
                'status'       => $status,
                'notes'        => $faker->optional(0.4)->sentence(),
                'photo'        => null,
                'started_at'   => $startedAt ? $startedAt->format('Y-m-d H:i:s') : null,
                'completed_at' => $completedAt ? $completedAt->format('Y-m-d H:i:s') : null,
                'created_at'   => $createdAt->format('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ]);
        }

        echo "✓ 60 housekeeping tasks created\n";
    }
}