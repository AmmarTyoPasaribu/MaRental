<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder{

    public function run(): void{
        
        User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('123'),
            'is_admin' => 1,
            ]);
    }
}
