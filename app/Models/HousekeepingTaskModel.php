<?php

namespace App\Models;

use CodeIgniter\Model;

class HousekeepingTaskModel extends Model
{
    protected $table            = 'housekeeping_tasks';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'room_id', 'assigned_to', 'task_type', 'status',
        'notes', 'photo', 'started_at', 'completed_at',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'room_id'   => 'required|integer',
        'task_type' => 'required|in_list[daily_clean,checkout_clean,deep_clean,inspection]',
        'status'    => 'required|in_list[pending,in_progress,done,verified]',
    ];
}