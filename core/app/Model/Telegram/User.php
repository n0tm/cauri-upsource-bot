<?php

namespace App\Model\Telegram;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 * @package App\Model
 *
 * @property int $id
 * @property int $user_id
 * @property int $review_chat_id
 */
class User extends Model
{
    use Notifiable;

    public $incrementing = false;

    protected $table = 'telegram_users';

    protected $fillable = [
        'id',
        'user_id',
        'review_chat_id',
    ];
}
