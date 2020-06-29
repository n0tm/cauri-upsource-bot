<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * Class TelegramUser
 * @package App\Model
 *
 * @property int $id
 * @property int $user_id
 * @property int $review_chat_id
 */
class TelegramUser extends Model
{
    use Notifiable;

    protected $fillable = [
        'id',
        'user_id',
        'review_chat_id',
    ];
}
