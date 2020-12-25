<?php

namespace App\Model\Upsource;

use Illuminate\Database\Eloquent\Model;
use App\Domain\Contract;

/**
 * Class Review
 * @package App\Model\Upsource
 *
 * @property string $id
 * @property string $creator_upsource_user_id
 * @property string $branch
 *
 * relations
 * @property Contract\Record\Upsource\User $upsourceUser
 */
class Review extends Model implements Contract\Record\Upsource\Review
{
	public const COLUMN_NAME_ID                       = 'id';
	public const COLUMN_NAME_CREATOR_UPSOURCE_USER_ID = 'creator_upsource_user_id';
	public const COLUMN_NAME_BRANCH                   = 'branch';

    public $incrementing = false;

    protected $table = 'upsource_reviews';

    protected $fillable = [
        'id',
        'creator_upsource_user_id',
        'branch',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|Contract\Record\Upsource\User
     */
    public function upsourceUser()
    {
        return $this->hasOne(User::class, 'id', 'creator_upsource_user_id');
    }

	public function getId(): string
	{
		return $this->id;
	}

	public function getCreatorUpsourceUserId(): string
	{
		return $this->creator_upsource_user_id;
	}

	public function getBranch(): string
	{
		return $this->branch;
	}

	/**
	 * @return \App\Domain\Implementation\Entity\Upsource\Review
	 */
	public function getEntity(): Contract\Entity\Basic
	{
		return new \App\Domain\Implementation\Entity\Upsource\Review($this);
	}

	public function getUpsourceUser(): Contract\Record\Upsource\User
	{
		return $this->upsourceUser;
	}
}
