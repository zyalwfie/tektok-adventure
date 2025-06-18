<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'slug', 'description', 'icon'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'name' => 'required|max_length[255]|min_length[3]',
        'description' => 'required|max_length[255]|min_length[3]',
        'icon' => 'required|max_length[255]'
    ];
    protected $validationMessages   = [
        'name' => [
            'required' => 'Nama kategori harus diisi!',
            'min_length' => 'Karakter terlalu pendek!',
            'max_length' => 'Karakter terlalu panjang!'
        ],
        'description' => [
            'required' => 'Deskripsi kategori harus diisi!',
            'min_length' => 'Karakter terlalu pendek!',
            'max_length' => 'Karakter terlalu panjang!'
        ],
        'icon' => [
            'required' => 'Icon kategori harus diisi!'
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
