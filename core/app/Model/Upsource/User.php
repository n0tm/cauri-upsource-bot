<?php

namespace App\Model\Upsource;

use Illuminate\Database\Eloquent\Model;

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
 * @property \App\Model\User $user
 */
class User extends Model
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
     * @return \App\Model\User
     */
    public function user()
    {
        return $this->belongsTo(\App\Model\User::class);
    }
}
