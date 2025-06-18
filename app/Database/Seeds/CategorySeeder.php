<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Camping Keluarga',
                'slug' => 'camping-keluarga',
                'description' => 'Tenda besar, sleeping bag keluarga, cooler box untuk liburan keluarga',
                'icon' => '<i class="ti ti-tent"></i>'
            ],
            [
                'name' => 'Alat Pendakian Gunung',
                'slug' => 'alat-pendakian-gunung',
                'description' => 'Tas carrier, sepatu hiking, trekking pole untuk petualangan ekstrem',
                'icon' => '<i class="ti ti-mountain"></i>'
            ],
            [
                'name' => 'Alat Bertahan Hidup',
                'slug' => 'alat-bertahan-hidup',
                'description' => 'Pisau multifungsi, water filter, poncho darurat untuk kondisi survival',
                'icon' => '<i class="ti ti-tool"></i>'
            ],
            [
                'name' => 'Perlengkapan Esensial',
                'slug' => 'perlengkapan-esensial',
                'description' => 'Koleksi peralatan dasar wajib untuk camping aman dan nyaman.',
                'icon' => '<i class="ti ti-checklist"></i>'
            ],
        ];

        $this->db->table('categories')->insertBatch($data);
    }
}
