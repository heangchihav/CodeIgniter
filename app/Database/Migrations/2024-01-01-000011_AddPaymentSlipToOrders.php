<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPaymentSlipToOrders extends Migration
{
    public function up()
    {
        $fields = [
            'payment_slip' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'notes',
            ],
        ];
        
        $this->forge->addColumn('orders', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('orders', 'payment_slip');
    }
}
