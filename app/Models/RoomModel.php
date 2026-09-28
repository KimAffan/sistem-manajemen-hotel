<?php

namespace App\Models;

use CodeIgniter\Model;

class RoomModel extends Model
{
    protected $table            = 'rooms';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'room_number', 'room_type_id', 'floor', 'status',
        'pos_x', 'pos_y', 'notes',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'room_number'  => 'required|max_length[10]|is_unique[rooms.room_number,id,{id}]',
        'room_type_id' => 'required|integer',
        'floor'        => 'required|integer|greater_than[0]',
        'status'       => 'required|in_list[vacant_clean,vacant_dirty,occupied,on_change,out_of_order,out_of_service]',
    ];

    protected $validationMessages = [
        'room_number' => [
            'required'  => 'Nomor kamar wajib diisi.',
            'is_unique' => 'Nomor kamar sudah dipakai.',
        ],
        'room_type_id' => [
            'required' => 'Tipe kamar wajib dipilih.',
        ],
        'floor' => [
            'required'     => 'Lantai wajib diisi.',
            'greater_than' => 'Lantai minimal 1.',
        ],
    ];
}