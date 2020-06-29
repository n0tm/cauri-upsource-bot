<?php

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
        \App\Model\UpsourceUser::query()->insert([
            ['id' => 'bfdf3437-542c-46ab-810f-fd5f21dc2333', 'name' => 'admin', 'project_id' => 'chip-test']
        ]);
    }
}
