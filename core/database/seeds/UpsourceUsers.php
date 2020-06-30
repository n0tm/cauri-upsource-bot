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
            ['id' => 'bfdf3437-542c-46ab-810f-fd5f21dc2333', 'name' => 'admin', 'user_id' => 1, 'project_id' => 'chip-test']
        ]);
    }
}
