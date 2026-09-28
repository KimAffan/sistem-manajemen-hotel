<?php

namespace App\Models;

use CodeIgniter\Model;

class ReservationRoomModel extends Model
{
    protected $table            = 'reservation_rooms';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['reservation_id', 'room_id', 'price_per_night', 'created_at'];

    // Timestamps dimatikan — created_at diisi manual dari controller
    protected $useTimestamps = false;
}