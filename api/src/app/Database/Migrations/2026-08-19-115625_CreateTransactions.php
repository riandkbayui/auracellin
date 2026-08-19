<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransactions extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'invoice' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'tracking_number' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'payment_photo' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'delivery_photo' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'total' => [
                'type'       => 'INT',
                'constraint' => '11',
            ],
            'description' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'city_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'full_address' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'sent', 'completed', 'failed'],
                'default'    => 'pending',
            ],
            'sent_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'completed_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
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
        $this->forge->createTable('transactions');
    }

    public function down()
    {
        $this->forge->dropTable('transactions');
    }
}
