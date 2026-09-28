<?php

namespace App\Models;

use CodeIgniter\Model;

class StoreRequisitionModel extends Model
{
    protected $table            = 'store_requisitions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'sr_number', 'department', 'requested_by', 'status',
        'requested_date', 'approved_by', 'approved_date', 'notes',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Generate nomor SR otomatis: SR-YYYYMMDD-XXXX
     */
    public function generateNumber(): string
    {
        $today  = date('Ymd');
        $prefix = "SR-{$today}-";

        $last = $this->like('sr_number', $prefix, 'after')
            ->orderBy('id', 'DESC')
            ->first();

        $next = 1;
        if ($last) {
            $next = (int) substr($last['sr_number'], -4) + 1;
        }

        return $prefix . str_pad($next, 4, '0', STR_PAD_LEFT);
    }
}