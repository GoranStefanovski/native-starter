<?php

namespace App\Applications\Common\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
class PostShort extends Model
{

    use SoftDeletes { restore as private restoreSoftDelete; }
    public $timestamps = true;

    protected $appends = [
//        'bagCount'
    ];

    protected $with = [
    ];


    protected $fillable = [
        'title',
        'link',
        'user_id',
        'event_id',
        'location_id',
        'artist_id',
        'is_active',
        'music_types',
        'location_types',
        'start_active_date',
        'end_active_date'
    ];

    protected $casts = [
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
    ];



    public function user(){
        return $this->belongsTo(User::class);
    }

}
