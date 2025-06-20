<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrderItemsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'constraint' => 11,
                'auto_increment' => true,
                'unsigned' => true,
            ],
            'order_id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'product_id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'quantity' => [
                'type' => 'int',
                'constraint' => 11
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => true
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('order_id', 'orders', 'id', 'cascade', 'cascade');
        $this->forge->addForeignKey('product_id', 'products', 'id', 'cascade', 'cascade');
        $this->forge->createTable('order_items');
    }

    public function down()
    {
        $this->forge->dropTable('order_items');
    }
}
