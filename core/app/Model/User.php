<?php

namespace App\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 * @package App\Model
 *
 * @property int $id
 * @property int $name
 * @property int $surname
 * @property int $email
 *
 * relations
 * @property \App\Model\Telegram\User $telegram
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'surname',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|Telegram\User
     */
    public function telegram()
    {
        return $this->hasOne(Telegram\User::class);
    }
}
