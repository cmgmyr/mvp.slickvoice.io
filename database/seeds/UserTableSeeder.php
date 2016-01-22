<?php

use Illuminate\Database\Seeder;
use Sv\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Chris Gmyr',
            'email' => 'cmgmyr@gmail.com',
            'password' => 'password',
            'admin' => true,
            'active' => true,
        ]);
    }
}
