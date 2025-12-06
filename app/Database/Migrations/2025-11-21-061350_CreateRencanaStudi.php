<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRencanaStudi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_rencana_studi' => ['type' => 'INT', 'auto_increment' => true, 'unsigned' => true],
            'nim' => ['type' => 'VARCHAR', 'constraint' => 15],
            'id_jadwal' => ['type' => 'INT', 'unsigned' => true],
            'nilai_angka' => ['type' => 'FLOAT'],
            'nilai_huruf' => ['type' => 'VARCHAR', 'constraint' => 5],
        ]);

        $this->forge->addKey('id_rencana_studi', true);
        $this->forge->createTable('rencana_studi');
    }

    public function down()
    {
        $this->forge->dropTable('rencana_studi');
    }
}
