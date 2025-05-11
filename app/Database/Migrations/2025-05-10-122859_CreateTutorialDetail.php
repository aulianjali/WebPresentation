<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTutorialDetail extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
                'unsigned'       => true,
            ],
            'tutorial_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'text' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'tutor_order' => [
                'type'       => 'INT',
                'constraint' => 5,
                'null'       => false,
                'default'    => 1,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['show', 'hide'],
                'default'    => 'hide',
            ],
            'url' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'code' => [
                'type' => 'TEXT',
                'null' => true,
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

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('tutorial_id', 'tutorial_masters', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tutorial_detail');
    }

    public function down()
    {
        $this->forge->dropTable('tutorial_detail');
    }
}
