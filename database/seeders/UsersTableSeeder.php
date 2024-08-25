<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id' => 1,
            'name' => 'test_user01',
            'email' => 'test_user01@example',
            'password' => 'password',
            ]);
            
        User::create([
            'id' => 2,
            'name' => 'test_user02',
            'email' => 'test_user02@example',
            'password' => 'password',
            ]);
    }
}
