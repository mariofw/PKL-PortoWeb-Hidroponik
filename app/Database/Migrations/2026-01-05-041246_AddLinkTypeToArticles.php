<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLinkTypeToArticles extends Migration
{
    public function up()
    {
        $fields = [
            'link_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'internal', // internal or external
                'after'      => 'slug'
            ],
            'external_url' => [
                'type'       => 'TEXT',
                'null'       => true,
                'after'      => 'link_type'
            ],
        ];
        $this->forge->addColumn('articles', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('articles', ['link_type', 'external_url']);
    }
}