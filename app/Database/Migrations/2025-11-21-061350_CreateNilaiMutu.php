<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNilaiMutu extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'nilai_huruf' => ['type' => 'VARCHAR', 'constraint' => 5],
            'nilai_mutu' => ['type' => 'FLOAT'],
        ]);

        $this->forge->addKey('nilai_huruf', true);
        $this->forge->createTable('nilai_mutu');
    }

    public function down()
    {
        $this->forge->dropTable('nilai_mutu');
    }
}
