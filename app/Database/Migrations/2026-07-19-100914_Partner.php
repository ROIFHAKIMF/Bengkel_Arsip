<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Partner extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'    => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama'  => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'logo'  => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('partner');
    }

    public function down()
    {
        $this->forge->dropTable('partner');
    }
}