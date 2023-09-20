<?php

namespace App\Applications\Common\Model;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media as MediaModel;
use Webpatser\Countries\Countries;
use App\Applications\Common\Model\LocationTypes;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Location extends Model implements HasMedia
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
        'working_hours',
    ];


    protected $fillable = [
        'title',
        'description',
        'rating',
        'country_id',
        'country',
        'image',
        'address',
        'owner',
        'user_id',
        'city',
        'is_active',
        'location_types',
        'website',
        'website_second',
        'contact_person',
        'contact_person_second',
        'contact_person_phone',
        'contact_person_phone_second',
        'contact_person_email',
        'contact_person_email_second',
        'start_active_date',
        'end_active_date'
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

    public function working_hours() {
        return $this->hasOne(WorkingHours::class);
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
