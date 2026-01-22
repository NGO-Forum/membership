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
            [
                'name' => 'Mr. CHAN Vicheth',
                'ngo' => 'NGO Forum Cambodia',
                'email' => 'vicheth@ngoforum.org.kh',
                'role' => 'manager',
                'password' => '@info#NGOF2025Membership'
            ],
            // [
            //     'name' => 'Mr. SOEUNG Saroeun',
            //     'ngo' => 'NGO Forum Cambodia',
            //     'email' => 'saroeun@ngoforum.org.kh',
            //     'role' => 'ed',
            //     'password' => '@info#NGOF2025Membership'
            // ],
            // [
            //     'name' => 'Mr. TOURT Chamroen',
            //     'ngo' => 'NGO Forum Cambodia',
            //     'email' => 'director@vbnk.org',
            //     'role' => 'board',
            //     'password' => '@info#NGOF2025Membership'
            // ],
            // [
            //     'name' => 'Mr. SOM Chettana',
            //     'ngo' => 'NGO Forum Cambodia',
            //     'email' => 'chettana@ngoforum.org.kh',
            //     'role' => 'operations',
            //     'password' => '@info#NGOF2025Membership'
            // ],
            [
                'name' => 'Admin',
                'ngo' => 'NGO Forum Cambodia',
                'email' => 'info@ngoforum.org.kh',
                'role' => 'admin',
                'password' => '@info#NGOF2025Membership'
            ],
            [
                'name' => 'RITI Program',
                'ngo' => 'NGO Forum Cambodia',
                'email' => 'riti@ngoforum.org.kh',
                'role' => 'riti',
                'password' => '@riti#NGOF2025'
            ],
            [
                'name' => 'SACHAS Program',
                'ngo' => 'NGO Forum Cambodia',
                'email' => 'schas@ngoforum.org.kh',
                'role' => 'sachas',
                'password' => '@sachas#NGOF2025'
            ],
            [
                'name' => 'PALI Program',
                'ngo' => 'NGO Forum Cambodia',
                'email' => 'pali@ngoforum.org.kh',
                'role' => 'pali',
                'password' => '@pali#NGOF2025'
            ],
            [
                'name' => 'MACOR',
                'ngo' => 'NGO Forum Cambodia',
                'email' => 'macor@ngoforum.org.kh',
                'role' => 'macor',
                'password' => '@macor#NGOF2025'
            ],
        ];

        foreach ($users as $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
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
