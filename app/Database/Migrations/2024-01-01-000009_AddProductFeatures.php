<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProductFeatures extends Migration
{
    public function up()
    {
        $fields = [
            'original_price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'is_featured' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'is_new' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'is_popular' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'discount_percentage' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 0.00,
            ],
        ];
        
        $this->forge->addColumn('products', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('products', ['is_new', 'is_popular', 'discount_percentage', 'original_price', 'is_featured']);
    }
}
