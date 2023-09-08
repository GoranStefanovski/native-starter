<?php

namespace App\Applications\Common\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class MusicTypes extends Model 
{

    use SoftDeletes { restore as private restoreSoftDelete; }
    public $timestamps = true;

    protected $appends = [
//        'bagCount'
    ];

    protected $with = [
    ];


    protected $fillable = [
        'name',
        'order'
    ];

    protected $casts = [
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
    ];
}
