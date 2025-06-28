<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Service extends Migration
{
  public function up()
    {
        $this->forge->addField([
            'id'      => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'title'   => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'content' => [
                'type' => 'TEXT',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('services');
    }

    public function down()
    {
        $this->forge->dropTable('services');
    }
}
