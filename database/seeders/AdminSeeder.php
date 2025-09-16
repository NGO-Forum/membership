<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{

    public function run(): void
    {
        $users = [
            // [
            //     'name' => 'Bunna',
            //     'ngo' => 'NGO Forum Cambodia',
            //     'email' => 'support@ngoforum.org.kh',
            //     'role' => 'admin',
            //     'password' => 'UnifiP@$$w0rd'
            // ],
            // [
            //     'name' => 'Vicheth',
            //     'ngo' => 'NGO Forum Cambodia',
            //     'email' => 'vicheth@ngoforum.org.kh',
            //     'role' => 'manager',
            //     'password' => 'NecaAwg*2023'
            // ],
            // [
            //     'name' => 'Saroeun Chhun',
            //     'ngo' => 'NGO Forum Cambodia',
            //     'email' => 'saroeun@ngoforum.org.kh',
            //     'role' => 'ed',
            //     'password' => 'NecaAwg*2023'
            // ],
            // [
            //     'name' => 'Touch Chamroeun',
            //     'ngo' => 'NGO Forum Cambodia',
            //     'email' => 'director@vbnk.org',
            //     'role' => 'board',
            //     'password' => 'SecureBoard*2023'
            // ],
            // [
            //     'name' => 'Chettana',
            //     'ngo' => 'NGO Forum Cambodia',
            //     'email' => 'chettana@ngoforum.org.kh',
            //     'role' => 'operations',
            //     'password' => 'SecureOps*2023'
            // ],
            [
                'name' => 'Mengseu',
                'ngo' => 'NGO Forum Cambodia',
                'email' => 'mengseu.sork@student.passerellesnumeriques.org',
                'role' => 'admin',
                'password' => '1234567890'
            ],
        ];

        foreach ($users as $data) {
            User::updateOrCreate(
                ['email' => $data['email']], // prevents duplicate seeding
                [
                    'name' => $data['name'],
                    'ngo' => $data['ngo'],
                    'role' => $data['role'],
                    'password' => Hash::make($data['password']),
                ]
            );
        }
    }
}
