<?php

use Illuminate\Database\Seeder;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Model\User::query()->insert([
            ['name' => 'Андрей', 'surname' => 'Кутин', 'email' => 'andrey.kutin@cauri.com']
        ]);
    }
}
