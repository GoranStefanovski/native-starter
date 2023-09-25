<?php

namespace App\Applications\Common\Model;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media as MediaModel;
use Webpatser\Countries\Countries;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Applications\Common\Model\Like;
class OrganizationEvent extends Model implements HasMedia
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
        'likes'
    ];


    protected $fillable = [ 
        'title',
        'name',
        'description',
        'rating',
        'image',
        'owner',
        'user_id',
        'city',
        'activity_going',
        'activity_interested',
        'event_type_id',
        'address',
        'location_name',
        'location_id',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'is_active',
        'music_types',
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
        $this->addMediaCollection('organization_events_image')
            ->singleFile();
    }

    public function registerMediaConversions(MediaModel $media = null) : void
    {
        $this->addMediaConversion('400')
            ->fit('max', 400, 0)
            ->optimize()->keepOriginalImageFormat()
            ->performOnCollections('organization_events_image');

        $this->addMediaConversion('200')
            ->fit('max', 200, 0)
            ->optimize()->keepOriginalImageFormat()
            ->performOnCollections('organization_events_image');
    }

    public function image()
    {
        return $this->getFirstMedia('organization_events_image');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
    }
}
