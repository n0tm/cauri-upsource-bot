<?php

namespace App\Model\Upsource;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Review
 * @package App\Model\Upsource
 *
 * @property $id
 * @property $creator_upsource_user_id
 * @property $branch
 *
 * relations
 * @property User $upsourceUser
 */
class Review extends Model
{
    public $incrementing = false;

    protected $table = 'upsource_reviews';

    protected $fillable = [
        'id',
        'creator_upsource_user_id',
        'branch',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|User
     */
    public function upsourceUser()
    {
        return $this->hasOne(User::class, 'id', 'creator_upsource_user_id');
    }
}
