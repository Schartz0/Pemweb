<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMataKuliah extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_mata_kuliah' => ['type' => 'INT', 'auto_increment' => true, 'unsigned' => true],
            'kode_mata_kuliah' => ['type' => 'VARCHAR', 'constraint' => 20],
            'nama_mata_kuliah' => ['type' => 'VARCHAR', 'constraint' => 100],
            'sks' => ['type' => 'INT', 'constraint' => 2],
        ]);

        $this->forge->addKey('id_mata_kuliah', true);
        $this->forge->createTable('mata_kuliah');
    }

    public function down()
    {
        $this->forge->dropTable('mata_kuliah');
    }
}
