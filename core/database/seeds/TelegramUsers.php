<?php

use App\Model\Telegram\User;
use Illuminate\Database\Seeder;

class TelegramUsers extends Seeder
{
    private const REVIEW_CHAT_ID_CHIP    = -333247422;
    private const REVIEW_CHAT_ID_QUANTUM = -476587811;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->insert([
	        ['id' => 381671645, 'user_id' => 1, 'review_chat_id' => self::REVIEW_CHAT_ID_CHIP], // Андрей Кутин
	        ['id' => 367836666, 'user_id' => 2, 'review_chat_id' => self::REVIEW_CHAT_ID_QUANTUM], // Никита Хохлов
	        ['id' => 1943619, 'user_id' => 3, 'review_chat_id' => self::REVIEW_CHAT_ID_CHIP], // Тимур Шарапов
	        ['id' => 141581761, 'user_id' => 4, 'review_chat_id' => self::REVIEW_CHAT_ID_CHIP], // Евгений Сулагаев
	        ['id' => 400548789, 'user_id' => 5, 'review_chat_id' => self::REVIEW_CHAT_ID_CHIP], // Михаил Кобычев
	        ['id' => 950293168, 'user_id' => 6, 'review_chat_id' => self::REVIEW_CHAT_ID_CHIP], // Валерий Тотубалин
	        ['id' => 410207249, 'user_id' => 7, 'review_chat_id' => self::REVIEW_CHAT_ID_QUANTUM], // Влад Кармишкин
	        ['id' => 167603171, 'user_id' => 8, 'review_chat_id' => self::REVIEW_CHAT_ID_QUANTUM], // Зафар Риаметов
	        ['id' => 491011602, 'user_id' => 9, 'review_chat_id' => self::REVIEW_CHAT_ID_QUANTUM], // Никита Ракчеев
	        ['id' => 473941483, 'user_id' => 10, 'review_chat_id' => self::REVIEW_CHAT_ID_QUANTUM], // Станислава Солнышкина
        ]);
    }
}
