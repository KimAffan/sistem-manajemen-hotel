<?php

namespace App\Models;

use CodeIgniter\Model;

class SrDetailModel extends Model
{
    protected $table            = 'sr_details';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['sr_id', 'item_id', 'quantity_requested', 'quantity_approved', 'notes', 'created_at'];

    // Matikan timestamps otomatis — created_at diisi manual
    protected $useTimestamps = false;
}