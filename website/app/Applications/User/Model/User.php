<?php

namespace App\Applications\User\Model;



//use App\Applications\Product\Model\Offer;
//use App\Applications\Product\Model\Product;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media as MediaModel;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Webpatser\Countries\Countries;
use Shanmuga\LaravelEntrust\Traits\LaravelEntrustUserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use App\Applications\Common\Model\Like;

class User extends Authenticatable implements JWTSubject, HasMedia
{
    use HasApiTokens, Notifiable;
    use InteractsWithMedia;
    use LaravelEntrustUserTrait;
    use SoftDeletes { restore as private restoreSoftDelete; }

    protected $appends = [
        'home_path',
//        'bagCount'
    ];

    protected $with = [
        'country',
        'media',
        'likes'
    ];

    protected $casts = [
        'type_id' => 'integer',
        'email_verified_at' => 'datetime',
    ];

    protected $fillable = [
        'username',
        'phone',
        'company',
        'first_name',
        'last_name',
        'email',
        'contact_email',
        'password',
        'country_id',
        'is_disabled',
        'source',
        'source_info',
        'activation_code',
        'sub_type',
        'sub_name'
    ];

    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at',
    ];

//    public function restore(){
//        $this->restoreEntrust();
//        $this->restoreSoftDelete();
//    }

//    public function offers()
//    {
//        return $this->belongsToMany(Offer::class,'offers');
//    }

//    public function getBagCountAttribute()
//    {
//        return $this->hasMany(Offer::class)->doesntHave('order')->count();
//    }


    public function isAdmin()
    {
        return $this->roles()->pluck('id')->contains(1); // We need to take this function off
//        return true;
    }

    public function isCollaborator()
    {
        return $this->roles()->pluck('id')->contains(2); // We need to take this function off
//        return true;
    }

    public function isPublic()
    {
        return $this->roles()->pluck('id')->contains(3);
    }


    public function isOrganizator()
    {
        return $this->roles()->pluck('id')->contains(4); // We need to take this function off
    }

    public function isArtist()
    {
        return $this->roles()->pluck('id')->contains(5); // We need to take this function off
    }

    public function isNormal()
    {
        return !$this->roles()->pluck('id')->contains(1);
    }

    public function getTypeText()
    {
        switch ($this->roles()->pluck('id')) {
            case 1:
            return __('strings.admin');
            case 2:
            return __('strings.normal');
            case 3:
            return __('strings.public');
        }
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function country()
    {
        return $this->belongsTo(Countries::class, 'country_id');
    }

    public function roles_array()
    {
        return $this->roles()->allRelatedIds()->toArray();
//        return [ "user_write", "user_view", "location_write", "location_view", "magazine_write", "magazine_view", "public_user",
//            "provider_write", "provider_view", "request_write", "request_view", "job_write", "job_view", "homepage_write", "homepage_view", "seocategory_write",
//            "seocategory_view", "seopage_write", "seopage_view", "helpcenter_write", "helpcenter_view", "box6_write", "box6_view"];
    }


    public function permissions_array(){
        $permissions = [];
        foreach($this->roles as $role){
            $permissions = array_unique(array_merge($permissions, $role->permissions->pluck('name')->toArray()));
        }
        return $permissions;
    }

    public function getHomePathAttribute()
    {
        // TODO: Manage this properly
        return '/';
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getFullNameAttribute() {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }

    public function registerMediaCollections() : void
    {
        $this->addMediaCollection('user_avatars')
            ->singleFile();
    }

    public function registerMediaConversions(MediaModel $media = null) : void
    {
        $this->addMediaConversion('400')
            ->fit('max', 400, 0)
            ->optimize()->keepOriginalImageFormat()
            ->performOnCollections('user_avatars');

        $this->addMediaConversion('200')
            ->fit('max', 200, 0)
            ->optimize()->keepOriginalImageFormat()
            ->performOnCollections('user_avatars');
    }

    public function image()
    {
        return $this->getFirstMedia('user_avatars');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
