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
	        ['name' => 'Андрей', 'surname' => 'Кутин', 'email' => 'andrey.kutin@cauri.com', 'id' => 1],
	        ['name' => 'Никита', 'surname' => 'Хохлов', 'email' => 'nikita.hohlov@cauri.com', 'id' => 2],
	        ['name' => 'Тимур', 'surname' => 'Шарапов', 'email' => 'timur.sharapov@cauri.com', 'id' => 3],
	        ['name' => 'Евгений', 'surname' => 'Сулагаев', 'email' => 'evgeniy.sulagaev@cauri.com', 'id' => 4],
	        ['name' => 'Михаил', 'surname' => 'Кобычев', 'email' => 'mikhail.kobychev@cauri.com', 'id' => 5],
	        ['name' => 'Валерий', 'surname' => 'Тотубалин', 'email' => 'valeriy.totubalin@cauri.com', 'id' => 6],
	        ['name' => 'Владислав', 'surname' => 'Кармишкин', 'email' => 'vladislav.karmishkin@cauri.com', 'id' => 7],
	        ['name' => 'Зафар', 'surname' => 'Ризаметов', 'email' => 'zafar.rizametov@cauri.com', 'id' => 8],
	        ['name' => 'Никита', 'surname' => 'Ракчеев', 'email' => 'nikita.rakcheev@cauri.com', 'id' => 9],
	        ['name' => 'Станислава', 'surname' => 'Солнышкина', 'email' => 'stanislava.solnyshkina@cauri.com', 'id' => 10],
        ]);
    }
}
