<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'       => 'John Doe',
                'email'      => 'john@example.com',
                'password'   => password_hash('password123', PASSWORD_DEFAULT),
                'phone'      => '+1234567890',
                'address'    => '123 Main St, City, Country',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'       => 'Jane Smith',
                'email'      => 'jane@example.com',
                'password'   => password_hash('password123', PASSWORD_DEFAULT),
                'phone'      => '+0987654321',
                'address'    => '456 Oak Ave, Town, Country',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('customers')->insertBatch($data);
    }
}
