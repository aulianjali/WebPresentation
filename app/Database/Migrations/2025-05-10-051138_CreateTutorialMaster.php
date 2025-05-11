<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTutorialMaster extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'auto_increment' => true, 'unsigned' => true],
            'judul'          => ['type' => 'VARCHAR', 'constraint' => 255],
            'kode_matkul'    => ['type' => 'VARCHAR', 'constraint' => 100],
            'nama_matkul'    => ['type' => 'VARCHAR', 'constraint' => 255],
            'url_presentation'=> ['type' => 'VARCHAR', 'constraint' => 255],
            'url_finished'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'creator_email'  => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tutorial_masters');
    }

    public function down()
    {
        $this->forge->dropTable('tutorial_masters');
    }
}


