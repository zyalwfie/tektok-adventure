<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');
        $categories = [1, 2, 3, 4]; // Sesuaikan dengan ID kategori yang ada

        $products = [];
        $productNames = [
            1 => ['Tenda Keluarga 4 Orang', 'Sleeping Bag Double', 'Cooler Box 30L', 'Kompor Portable 2 Tungku'],
            2 => ['Tas Carrier 60L', 'Sepatu Hiking Waterproof', 'Trekking Pole Aluminium', 'Headlamp LED'],
            3 => ['Pisau Multitool 12-in-1', 'Water Filter Portable', 'Poncho Darurat', 'Fire Starter'],
            4 => ['Tenda Dome 2 Orang', 'Sleeping Bag Standard', 'Matras Lipat', 'Senter LED']
        ];

        for ($i = 0; $i < 15; $i++) {
            $categoryId = $faker->randomElement($categories);
            $productName = $faker->randomElement($productNames[$categoryId]);

            $products[] = [
                'category_id'  => $categoryId,
                'is_featured' => $faker->boolean(30),
                'image'       => 'default.svg',
                'name'        => $productName,
                'slug'        => strtolower(str_replace(' ', '-', $productName)) . '-' . $faker->unique()->numberBetween(100, 999),
                'description' => $this->generateDescription($productName, $faker),
                'price'       => $faker->numberBetween(150000, 3000000),
                'discount'    => $faker->boolean(40) ? $faker->numberBetween(5, 70) : 0, // Diskon 5-70% (40% produk dapat diskon)
                'stock'       => $faker->numberBetween(0, 50),
                'created_at'  => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at'  => date('Y-m-d H:i:s')
            ];
        }

        $this->db->table('products')->insertBatch($products);
    }

    protected function generateDescription($productName, $faker)
    {
        $materials = [
            'berbahan aluminium alloy',
            'dengan material polyester tahan air',
            'menggunakan karet anti slip',
            'dilapisi waterproof coating'
        ];

        $features = [
            'Desain ergonomis',
            'Ringan dan portable',
            'Tahan cuaca ekstrem',
            'Garansi 1 tahun',
            'Cocok untuk pemula'
        ];

        return sprintf(
            "%s %s.\n\nFitur Utama:\n%s\n\n%s",
            $productName,
            $faker->randomElement($materials),
            implode("\n- ", $faker->randomElements($features, 3)),
            $faker->randomElement([
                'Dapatkan segera sebelum kehabisan!',
                'Best seller dengan rating 4.8/5!',
                'Produk ini sudah teruji di lapangan.'
            ])
        );
    }
}
