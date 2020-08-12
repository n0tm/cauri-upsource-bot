<?php

use App\Model\Upsource\User;
use Illuminate\Database\Seeder;

class UpsourceUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->insert([
            ['id' => 'd364164f-3e18-404f-949b-6da469de937a', 'name' => 'andrey.kutin', 'user_id' => 1, 'project_id' => 'cauri-chip'],
	        ['id' => '0211f35a-2178-41ba-927b-24eb342b30f5', 'name' => 'nikita.hohlov', 'user_id' => 2, 'project_id' => 'cauri-quantum'],
	        ['id' => '85c52c4b-74c9-41a5-b162-f19f085dd6bf', 'name' => 'timur.sharapov', 'user_id' => 3, 'project_id' => 'cauri-chip'],
	        ['id' => '1e0bdc7e-5155-4bab-8d06-6a3a7ddd4da1', 'name' => 'evgeniy.sulagaev', 'user_id' => 4, 'project_id' => 'cauri-chip'],
	        ['id' => '1d2ac830-2483-47b5-80ba-031fbf69fccb', 'name' => 'mikhail.kobychev', 'user_id' => 5, 'project_id' => 'cauri-chip'],
	        ['id' => '8c7be6c2-6750-43fc-a8d8-bc8057c4f3f4', 'name' => 'valeriy.totubalin', 'user_id' => 6, 'project_id' => 'cauri-chip'],
	        ['id' => '32dcf348-9762-47bd-8b34-32d5ecd071de', 'name' => 'vladislav.karmishkin', 'user_id' => 7, 'project_id' => 'cauri-quantum'],
	        ['id' => '63bb61f1-888a-49e2-8b49-432451ec6610', 'name' => 'zafar.rizametov', 'user_id' => 8, 'project_id' => 'cauri-quantum'],
        ]);
    }
}
