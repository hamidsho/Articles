<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Posts extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 200
            ],
            'content' => [
                'type' => 'TEXT'
            ],
            'category' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'created_date' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_date' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'status' => [
                'type'           => 'ENUM',
                'constraint'     => ['Publish', 'Draft', 'Trash'],
                'default'        => 'Draft'
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('posts');
    }

    public function down()
    {
        //
    }
}
