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
 */
class User extends Model
{
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'project_id',
        'user_id',
    ];
}
