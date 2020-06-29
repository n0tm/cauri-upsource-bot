<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TelegramUser extends Model
{
    use Notifiable;

    protected $table = 'telegram_users';

    protected $fillable = [
        'id',
        'user_id',
        'review_chat_id',
    ];
}
