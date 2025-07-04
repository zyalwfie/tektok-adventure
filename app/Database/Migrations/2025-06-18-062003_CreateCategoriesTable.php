<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCategoryTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'constraint' => 255,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'name' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'slug' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'description' => [
                'type' => 'text',
                'null' => true
            ],
            'icon' => [
                'type' => 'varchar',
                'constraint' => 255
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('categories');
    }

    public function down()
    {
        $this->forge->dropTable('categories');
    }
} 