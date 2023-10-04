<?php

namespace App\Applications\User\Model;

use Illuminate\Database\Eloquent\Model;

class UserInterests extends Model
{
    protected $table = 'user_interests';
    public $timestamps = true;

    protected $fillable = array(
        'music_types',
        'location_types'
    );
}
