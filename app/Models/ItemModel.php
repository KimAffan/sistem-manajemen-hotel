<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemModel extends Model
{
    protected $table            = 'items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'category_id', 'code', 'name', 'unit',
        'current_stock', 'minimum_stock', 'last_price', 'expiry_date',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

   protected $validationRules = [
    'name'          => 'required|min_length[3]|max_length[100]',
    'category_id'   => 'required|integer',
    'unit'          => 'required|max_length[20]',
    'current_stock' => 'permit_empty|integer',
    'minimum_stock' => 'permit_empty|integer',
    'last_price'    => 'permit_empty|numeric',
    'code'          => 'permit_empty|max_length[20]',
];

    protected $validationMessages = [
        'name' => [
            'required'   => 'Nama barang wajib diisi.',
            'min_length' => 'Nama minimal 3 karakter.',
        ],
        'category_id' => [
            'required' => 'Kategori wajib dipilih.',
        ],
        'code' => [
            'is_unique' => 'Kode barang sudah dipakai.',
        ],
    ];

    /**
     * Generate kode barang otomatis: ITM-XXXX
     */
    public function generateCode(): string
    {
        $last = $this->like('code', 'ITM-', 'after')
            ->orderBy('id', 'DESC')
            ->first();

        $next = 1;
        if ($last) {
            $next = (int) substr($last['code'], -4) + 1;
        }

        return 'ITM-' . str_pad($next, 4, '0', STR_PAD_LEFT);
    }
}