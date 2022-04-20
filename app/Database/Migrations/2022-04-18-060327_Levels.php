<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Levels extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'levelid' => [
                'type' => 'int',
                'unsigned' => TRUE
            ],
            'levelnama' => [
                'type' => 'varchar',
                'constraint' => '100'
            ]
        ]);
        $this->forge->addKey('levelid');
        $this->forge->createTable('levels');
    }

    public function down()
    {
        $this->forge->dropTable('levels');
    }
}
