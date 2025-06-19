<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

use function PHPSTORM_META\type;

class Cart extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'constraint' => 11,
                'auto_increment' => true,
                'unsigned' => true
            ],
            'user_id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true
            ],
            'product_id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true
            ],
            'quantity' => [
                'type' => 'int',
                'constraint' => 11,
                'default' => 1,
            ],
            'price_at_add' => [
                'type' => 'int',
                'constraint' => 11
            ],
            'created_at' => ['type' => 'datetime', 'null' => true],
            'updated_at' => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', '', 'cascade');
        $this->forge->addForeignKey('product_id', 'products', 'id', '', 'cascade');
        $this->forge->createTable('carts');
    }

    public function down()
    {
        $this->forge->dropTable('carts');
    }
}
