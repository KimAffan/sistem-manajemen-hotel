<?php

namespace App\Models;

use CodeIgniter\Model;

class AppSettingModel extends Model
{
    protected $table            = 'app_settings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['key', 'value', 'group'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Ambil semua settings sebagai array key => value
     */
    public function getAllKeyed(): array
    {
        $rows = $this->findAll();
        $result = [];
        foreach ($rows as $row) {
            $result[$row['key']] = $row['value'];
        }
        return $result;
    }

    /**
     * Ambil satu nilai berdasarkan key
     */
    public function getValue(string $key, $default = null)
    {
        $row = $this->where('key', $key)->first();
        return $row ? $row['value'] : $default;
    }

    /**
     * Set atau update nilai
     */
    public function setValue(string $key, $value): bool
    {
        $existing = $this->where('key', $key)->first();
        if ($existing) {
            return $this->update($existing['id'], ['value' => $value]);
        }
        return (bool) $this->insert(['key' => $key, 'value' => $value]);
    }

    /**
     * Update banyak settings sekaligus
     */
    public function setMany(array $data): void
    {
        foreach ($data as $key => $value) {
            $this->setValue($key, $value);
        }
    }
}