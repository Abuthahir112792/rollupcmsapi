<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create(['name'=>'shop_keeper',
            'email'=>'hello@yougo.com',
            'password'=>\Illuminate\Support\Facades\Hash::make('yougoeasybuy'),
            'role'=>'shop_keeper']);
    }
}
