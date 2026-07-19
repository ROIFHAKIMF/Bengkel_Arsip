<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KonsultasiPaket extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_paket' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'harga'      => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'default'    => 0,
            ],
            'deskripsi'  => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('konsultasi_paket');
    }

    public function down()
    {
        $this->forge->dropTable('konsultasi_paket');
    }
}