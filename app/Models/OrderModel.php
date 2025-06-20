<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table            = 'orders';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'status', 'total_price', 'street_address', 'recipient_name', 'recipient_email', 'recipient_phone', 'notes'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'street_address' => 'required',
        'recipient_name' => 'required|max_length[255]',
        'recipient_email' => 'permit_empty|valid_email',
        'recipient_phone' => [
            'label' => 'Nomor Telepon',
            'rules' => 'required|regex_match[/^(\+62|62|0)8[1-9][0-9]{6,10}$/]'
        ],
    ];
    protected $validationMessages = [
        'recipient_name' => [
            'required' => 'Nama penerima wajib diisi!',
            'max_length' => 'Karakter terlalu panjang!'
        ],
        'recipient_email' => [
            'valid_email' => 'Tolong masukkan email yang valid!'
        ],
        'street_address' => [
            'required' => 'Alamat wajib diisi!'
        ],
        'recipient_phone' => [
            'required' => 'Nomor telepon wajib diisi!',
            'regex_match' => 'Nomor telepon tidak valid!'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
