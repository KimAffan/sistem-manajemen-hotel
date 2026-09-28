<?php

namespace App\Models;

use CodeIgniter\Model;

class GuestModel extends Model
{
    protected $table            = 'guests';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'full_name', 'id_number', 'phone', 'email', 'address',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'full_name' => 'required|min_length[3]|max_length[100]',
        'phone'     => 'permit_empty|max_length[20]',
        'email'     => 'permit_empty|valid_email|max_length[100]',
        'id_number' => 'permit_empty|max_length[50]',
    ];

    protected $validationMessages = [
        'full_name' => [
            'required'   => 'Nama lengkap wajib diisi.',
            'min_length' => 'Nama minimal 3 karakter.',
        ],
        'email' => [
            'valid_email' => 'Format email tidak valid.',
        ],
    ];
}