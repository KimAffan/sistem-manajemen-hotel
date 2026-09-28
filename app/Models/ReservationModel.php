<?php

namespace App\Models;

use CodeIgniter\Model;

class ReservationModel extends Model
{
    protected $table            = 'reservations';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'reservation_code', 'guest_id', 'check_in_date', 'check_out_date',
        'total_price', 'status', 'notes', 'created_by',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'guest_id'        => 'required|integer',
        'check_in_date'   => 'required|valid_date[Y-m-d]',
        'check_out_date'  => 'required|valid_date[Y-m-d]',
    ];

    /**
     * Generate kode reservasi unik: RSV-YYYYMMDD-XXXX
     */
    public function generateCode(): string
    {
        $today  = date('Ymd');
        $prefix = "RSV-{$today}-";

        $last = $this->where('reservation_code LIKE', $prefix . '%')
            ->orderBy('id', 'DESC')
            ->first();

        $nextNumber = 1;
        if ($last) {
            $lastNumber = (int) substr($last['reservation_code'], -4);
            $nextNumber = $lastNumber + 1;
        }

        return $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Cek ketersediaan kamar di rentang tanggal tertentu.
     */
   public function isRoomAvailable(int $roomId, string $checkIn, string $checkOut, int $excludeReservationId = 0): bool
{
    $db = \Config\Database::connect();

    $builder = $db->table('reservation_rooms rr')
        ->join('reservations r', 'r.id = rr.reservation_id')
        ->where('rr.room_id', $roomId)
        // Hanya 'cancelled' yang diabaikan (reservasi batal)
        // Semua status lain tetap memblokir tanggal, termasuk checked_out
        ->where('r.status !=', 'cancelled')
        // Overlap: (checkIn < existingOut) AND (checkOut > existingIn)
        ->where('r.check_in_date <', $checkOut)
        ->where('r.check_out_date >', $checkIn);

    if ($excludeReservationId > 0) {
        $builder->where('r.id !=', $excludeReservationId);
    }

    return $builder->countAllResults() === 0;
}
}