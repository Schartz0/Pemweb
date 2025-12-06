<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRuangan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_ruangan' => ['type' => 'INT', 'auto_increment' => true, 'unsigned' => true],
            'nama_ruangan' => ['type' => 'VARCHAR', 'constraint' => 50],
        ]);

        $this->forge->addKey('id_ruangan', true);
        $this->forge->createTable('ruangan');
    }

    public function down()
    {
        $this->forge->dropTable('ruangan');
    }
}
