<?php

namespace App\Models;

use CodeIgniter\Model;

class SupplierModel extends Model
{
    protected $table            = 'suppliers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'contact_person', 'phone', 'email', 'address'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[100]',
        'email' => 'permit_empty|valid_email|max_length[100]',
        'phone' => 'permit_empty|max_length[20]',
    ];

    protected $validationMessages = [
        'name' => [
            'required'   => 'Nama supplier wajib diisi.',
            'min_length' => 'Nama minimal 3 karakter.',
        ],
        'email' => [
            'valid_email' => 'Format email tidak valid.',
        ],
    ];
}