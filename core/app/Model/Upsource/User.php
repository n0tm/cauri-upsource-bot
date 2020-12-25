<?php

namespace App\Model\Upsource;

use Illuminate\Database\Eloquent\Model;
use App\Domain\Contract;

/**
 * Class User
 * @package App\Model
 *
 * @property string $id
 * @property string $name
 * @property string $project_id
 * @property int $user_id
 *
 * relations
 * @property Contract\Record\User $user
 */
class User extends Model implements Contract\Record\Upsource\User
{
    public $incrementing = false;

    protected $table = 'upsource_users';

    protected $fillable = [
        'id',
        'name',
        'project_id',
        'user_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Contract\Record\User
     */
    public function user()
    {
        return $this->belongsTo(\App\Model\User::class);
    }

	/**
	 * @return \App\Domain\Implementation\Entity\Upsource\User
	 */
	public function getEntity(): Contract\Entity\Basic
	{
		return new \App\Domain\Implementation\Entity\Upsource\User($this);
	}

	public function getId(): string
	{
		return $this->id;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getProjectId(): string
	{
		return $this->project_id;
	}

	public function getUserId(): int
	{
		return $this->user_id;
	}

	public function getUser(): Contract\Record\User
	{
		return $this->user;
	}
}
