<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'category_id',
        'is_featured',
        'image',
        'name',
        'slug',
        'description',
        'discount',
        'price',
        'stock'
    ];

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
    protected $validationRules      = [
        'category_id' => 'required',
        'name' => 'required|min_length[3]|max_length[255]',
        'slug' => 'required',
        'price' => 'required|integer'
    ];
    protected $validationMessages   = [
        'name' => [
            'required' => 'Name produk harus diisi!',
            'min_length' => 'Karakter terlalu pendek!',
            'max_length' => 'Karakter terlalu panjang!',
        ],
        'price' => [
            'required' => 'Harga harus diisi!',
            'integer' => 'Harga tidak boleh selain dari angka!',
        ],
        'category_id' => [
            'required' => 'Kategori harus diisi!',
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
