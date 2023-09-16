<?php

namespace App\Applications\Common\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class WorkingHours extends Model
{
    use SoftDeletes { restore as private restoreSoftDelete; }
    public $timestamps = true;

    protected $appends = [
    ];

    protected $with = [

    ];

    protected $fillable = [
        'location_id',
        'monday_start',
        'monday_end',
        'monday_working',
        'tuesday_start',
        'tuesday_end',
        'tuesday_working',
        'wednesday_start',
        'wednesday_end',
        'wednseday_working',
        'thursday_start',
        'thursday_end',
        'thursday_working',
        'friday_start',
        'friday_end',
        'friday_working',
        'saturday_start',
        'saturday_end',
        'saturday_working',
        'sunday_start',
        'sunday_end',
        'sunday_working',
        'open_24',
    ];

    protected $casts = [
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
    ];



}
