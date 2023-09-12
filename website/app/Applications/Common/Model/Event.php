<?php

namespace App\Applications\Common\Model;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media as MediaModel;
use Webpatser\Countries\Countries;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Event extends Model implements HasMedia
{
    use InteractsWithMedia;

    use SoftDeletes { restore as private restoreSoftDelete; }
    public $timestamps = true;

    protected $appends = [
//        'bagCount'
    ];

    protected $with = [
        'country',
        'media',
    ];


    protected $fillable = [
        'title',
        'name',
        'description',
        'rating',
        'image',
        'owner',
        'user_id',
        'activity_going',
        'activity_interested',
        'event_type_id',
        'music_type_id',
        'location_id',
        'is_active'
    ];

    protected $casts = [
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
    ];


    public function country()
    {
        return $this->belongsTo(Countries::class, 'country_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }


    public function registerMediaCollections() : void
    {
        $this->addMediaCollection('event_image')
            ->singleFile();
    }

    public function registerMediaConversions(MediaModel $media = null) : void
    {
        $this->addMediaConversion('400')
            ->fit('max', 400, 0)
            ->optimize()->keepOriginalImageFormat()
            ->performOnCollections('event_image');

        $this->addMediaConversion('200')
            ->fit('max', 200, 0)
            ->optimize()->keepOriginalImageFormat()
            ->performOnCollections('event_image');
    }

    public function image()
    {
        return $this->getFirstMedia('event_image');
    }

}
