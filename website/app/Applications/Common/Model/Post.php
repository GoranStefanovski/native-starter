<?php

namespace App\Applications\Common\Model;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media as MediaModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
class Post extends Model implements HasMedia
{
    use InteractsWithMedia;

    use SoftDeletes { restore as private restoreSoftDelete; }
    public $timestamps = true;

    protected $appends = [
//        'bagCount'
    ];

    protected $with = [
        'media',
    ];


    protected $fillable = [
        'title',
        'description',
        'image',
        'user_id',
        'event_id',
        'location_id',
        'artist_id',
        'is_active',
        'is_boosted',
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

    public function registerMediaCollections() : void
    {
        $this->addMediaCollection('location_image')
            ->singleFile();
    }

    public function registerMediaConversions(MediaModel $media = null) : void
    {
        $this->addMediaConversion('400')
            ->fit('max', 400, 0)
            ->optimize()->keepOriginalImageFormat()
            ->performOnCollections('location_image');

        $this->addMediaConversion('200')
            ->fit('max', 200, 0)
            ->optimize()->keepOriginalImageFormat()
            ->performOnCollections('location_image');
    }

    public function image()
    {
        return $this->getFirstMedia('location_image');
    }

}
