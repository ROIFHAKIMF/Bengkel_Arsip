<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSocialMedia extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'auto_increment' => true],
            'wa_number'  => ['type' => 'VARCHAR', 'constraint' => 20],
            'instagram'  => ['type' => 'VARCHAR', 'constraint' => 255],
            'facebook'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'youtube'    => ['type' => 'VARCHAR', 'constraint' => 255],
            'email'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('social_media');
    }

    public function down()
    {
        $this->forge->dropTable('social_media');
    }
}