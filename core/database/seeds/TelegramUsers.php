<?php

use Illuminate\Database\Seeder;

class TelegramUsers extends Seeder
{
    private const REVIEW_CHAT_ID_TEST = -337143191;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Model\TelegramUser::query()->insert([
            ['id' => 381671645, 'user_id' => 1, 'review_chat_id' => self::REVIEW_CHAT_ID_TEST],
        ]);
    }
}
