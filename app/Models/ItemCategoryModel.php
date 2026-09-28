<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemCategoryModel extends Model
{
    protected $table            = 'item_categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'description'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = null;

    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[50]|is_unique[item_categories.name,id,{id}]',
    ];

    protected $validationMessages = [
        'name' => [
            'required'  => 'Nama kategori wajib diisi.',
            'is_unique' => 'Nama kategori sudah ada.',
        ],
    ];
}