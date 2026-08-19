<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductStocks extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'reference_table' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'reference_id' => [
                'type'       => 'INT',
                'constraint' => '11',
            ],
            'product_id' => [
                'type'       => 'INT',
                'constraint' => '11',
                'null'      => true,
            ],
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['in', 'out'],
            ],
            'description' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'qty' => [
                'type'       => 'INT',
                'constraint' => '11',
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'created_by' => [
                'type'    => 'INT',
                'constraint' => '11',
                'null'    => true,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'updated_by' => [
                'type'    => 'INT',
                'constraint' => '11',
                'null'    => true,
            ],
            'deleted_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'deleted_by' => [
                'type'    => 'INT',
                'constraint' => '11',
                'null'    => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('product_stocks');
    }

    public function down()
    {
        $this->forge->dropTable('product_stocks');
    }
}
