<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJadwal extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true, 'unsigned' => true],
            'nama_kelas' => ['type' => 'VARCHAR', 'constraint' => 50],
            'id_mata_kuliah' => ['type' => 'INT', 'unsigned' => true],
            'id_ruangan' => ['type' => 'INT', 'unsigned' => true],
            'nidn' => ['type' => 'VARCHAR', 'constraint' => 20],
            'hari' => ['type' => 'VARCHAR', 'constraint' => 20],
            'jam' => ['type' => 'VARCHAR', 'constraint' => 20],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('jadwal');
    }

    public function down()
    {
        $this->forge->dropTable('jadwal');
    }
}
