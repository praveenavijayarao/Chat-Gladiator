<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Clear existing users (optional - remove this if you want to keep existing users)
        $this->db->table('users')->truncate();
        
        // You can add users here if needed
        // Example:
        // $data = [
        //     [
        //         'name' => 'Admin User',
        //         'email' => 'admin@example.com',
        //         'password' => password_hash('your_password', PASSWORD_DEFAULT),
        //         'created_at' => date('Y-m-d H:i:s'),
        //         'updated_at' => date('Y-m-d H:i:s'),
        //     ],
        // ];
        // 
        // $this->db->table('users')->insertBatch($data);
    }
}
