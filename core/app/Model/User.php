<?php

namespace App\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Domain\Contract;

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
 * @property Contract\Record\Telegram\User $telegram
 */
class User extends Authenticatable implements Contract\Record\User
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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|Contract\Record\Telegram\User
     */
    public function telegram()
    {
        return $this->hasOne(Telegram\User::class);
    }

	/**
	 * @return \App\Domain\Implementation\Entity\User
	 */
	public function getEntity(): Contract\Entity\Basic
	{
		return new \App\Domain\Implementation\Entity\User($this);
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getSurname(): string
	{
		return $this->surname;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function getTelegram(): Contract\Record\Telegram\User
	{
		return $this->telegram;
	}
}
