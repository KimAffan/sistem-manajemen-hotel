<?php

namespace App\Models;

use CodeIgniter\Model;

class RoomTypeModel extends Model
{
    protected $table            = 'room_types';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'base_price', 'capacity', 'description'];

    // Timestamps
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'name'       => 'required|min_length[3]|max_length[50]|is_unique[room_types.name,id,{id}]',
        'base_price' => 'required|numeric|greater_than_equal_to[0]',
        'capacity'   => 'required|integer|greater_than[0]|less_than_equal_to[10]',
    ];

    protected $validationMessages = [
        'name' => [
            'required'   => 'Nama tipe kamar wajib diisi.',
            'min_length' => 'Nama tipe minimal 3 karakter.',
            'is_unique'  => 'Nama tipe kamar sudah ada.',
        ],
        'base_price' => [
            'required'              => 'Harga dasar wajib diisi.',
            'greater_than_equal_to' => 'Harga tidak boleh negatif.',
        ],
        'capacity' => [
            'required'    => 'Kapasitas wajib diisi.',
            'greater_than' => 'Kapasitas minimal 1 orang.',
        ],
    ];
}