<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class ReservationSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');
        $db    = \Config\Database::connect();

        $guests = $db->table('guests')->select('id')->get()->getResultArray();
        $rooms  = $db->table('rooms')
            ->select('rooms.id, room_types.base_price')
            ->join('room_types', 'room_types.id = rooms.room_type_id', 'left')
            ->get()->getResultArray();

        if (empty($guests) || empty($rooms)) {
            echo "⚠ Guests or rooms empty, skip reservation seeder.\n";
            return;
        }

        // ========================================
        // GENERATE 800 RESERVASI HISTORIS
        // ========================================
        echo "Generating 800 reservations...\n";

        for ($i = 0; $i < 800; $i++) {
            $guest    = $faker->randomElement($guests);
            $room     = $faker->randomElement($rooms);
            $checkIn  = $faker->dateTimeBetween('-6 months', '+1 month');
            $nights   = $faker->numberBetween(1, 5);
            $checkOut = (clone $checkIn)->modify("+{$nights} days");
            $price    = (float) $room['base_price'];
            $total    = $nights * $price;

            // Distribusi status berdasarkan tanggal
            if ($checkOut < new \DateTime()) {
                $status = $faker->randomElement(['checked_out', 'checked_out', 'checked_out', 'cancelled']);
            } elseif ($checkIn <= new \DateTime() && $checkOut >= new \DateTime()) {
                $status = $faker->randomElement(['checked_in', 'confirmed']);
            } else {
                $status = $faker->randomElement(['pending', 'confirmed']);
            }

            $code = 'RSV-' . $checkIn->format('Ymd') . '-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT);

            $db->table('reservations')->insert([
                'reservation_code' => $code,
                'guest_id'         => $guest['id'],
                'check_in_date'    => $checkIn->format('Y-m-d'),
                'check_out_date'   => $checkOut->format('Y-m-d'),
                'total_price'      => $total,
                'status'           => $status,
                'notes'            => $faker->optional(0.3)->sentence(),
                'created_by'       => 2,
                'created_at'       => $checkIn->modify('-2 days')->format('Y-m-d H:i:s'),
                'updated_at'       => $checkIn->format('Y-m-d H:i:s'),
            ]);
            $resId = $db->insertID();

            $db->table('reservation_rooms')->insert([
                'reservation_id'  => $resId,
                'room_id'         => $room['id'],
                'price_per_night' => $price,
                'created_at'      => $checkIn->format('Y-m-d H:i:s'),
            ]);
        }

        echo "✓ 800 reservations created\n";

        // ========================================
        // GENERATE 5 RESERVASI CHECK-IN HARI INI
        // ========================================
        echo "Generating today's reservations...\n";

        for ($i = 0; $i < 5; $i++) {
            $guest    = $faker->randomElement($guests);
            $room     = $faker->randomElement($rooms);
            $price    = (float) $room['base_price'];
            $nights   = $faker->numberBetween(1, 3);
            $checkOut = date('Y-m-d', strtotime("+{$nights} days"));

            $db->table('reservations')->insert([
                'reservation_code' => 'RSV-TODAY-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'guest_id'         => $guest['id'],
                'check_in_date'    => date('Y-m-d'),
                'check_out_date'   => $checkOut,
                'total_price'      => $nights * $price,
                'status'           => 'checked_in',
                'created_by'       => 2,
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ]);
            $resId = $db->insertID();

            $db->table('reservation_rooms')->insert([
                'reservation_id'  => $resId,
                'room_id'         => $room['id'],
                'price_per_night' => $price,
                'created_at'      => date('Y-m-d H:i:s'),
            ]);
        }

        echo "✓ 5 today's reservations created\n";
    }
}