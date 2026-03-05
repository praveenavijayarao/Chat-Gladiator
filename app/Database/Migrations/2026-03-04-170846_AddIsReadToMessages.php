<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsReadToMessages extends Migration
{
    public function up()
    {
        $this->forge->addColumn('messages', [
            'is_read' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'after' => 'message'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('messages', 'is_read');
    }
}
