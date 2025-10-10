<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $this->call([
            \Database\Seeders\AdminSeeder::class,
            \Database\Seeders\MembershipSeeder::class,
        ]);

    }
}