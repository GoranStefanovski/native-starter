<?php

namespace App\Applications\PageBuilder\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Page
 *
 * Represents a page in the PageBuilder application.
 *
 * @package App\Applications\PageBuilder\Model
 */
class Page extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pages';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'slug' => 'string',
        'body' => 'json',
    ];


    /**
     * Define a one-to-many relationship with containers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function containers()
    {
        return $this->hasMany(Container::class);
    }
}
