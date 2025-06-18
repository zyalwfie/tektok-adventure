<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'category_id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'is_featured' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'image' => [
                'type' => 'varchar',
                'constraint' => 255,
                'null' => true,
                'default' => 'default.svg',
            ],
            'name' => [
                'type' => 'varchar',
                'constraint' => 255,
            ],
            'slug' => [
                'type'       => 'varchar',
                'constraint' => 255,
                'unique'     => true,
            ],
            'description' => [
                'type' => 'text',
                'null' => true,
            ],
            'discount' => [
                'type' => 'int',
                'constraint' => 11,
                'null' => true,
            ],
            'price' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'stock' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('category_id', 'categories', 'id', '', 'CASCADE');
        $this->forge->createTable('products');
    }

    public function down()
    {
        $this->forge->dropTable('products');
    }
}
