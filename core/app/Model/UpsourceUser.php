<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UpsourceUser extends Model
{
    protected $fillable = [
        'id',
        'name',
        'project_id',
        'user_id',
    ];
}
