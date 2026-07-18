<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Testimoni extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'      => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama'    => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'foto'    => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'ulasan'  => [
                'type' => 'TEXT',
            ],
            'rating'  => [
                'type'       => 'INT',
                'constraint' => 1,
                'default'    => 5,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('testimoni');
    }

    public function down()
    {
        $this->forge->dropTable('testimoni');
    }
}