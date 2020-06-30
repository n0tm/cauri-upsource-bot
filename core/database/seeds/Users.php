<?php

use App\Model\User;
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
        User::query()->insert([
            ['name' => 'Андрей', 'surname' => 'Кутин', 'email' => 'andrey.kutin@cauri.com', 'id' => 1]
        ]);
    }
}
