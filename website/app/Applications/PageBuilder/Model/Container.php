<?php

namespace App\Applications\PageBuilder\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Container
 *
 * Represents a container associated with a page in the PageBuilder application.
 *
 * @package App\Applications\PageBuilder\Model
 */
class Container extends Model
{
    protected $table = 'containers';
    protected $fillable = ['name'];
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Define a many-to-one relationship with the parent page.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * Define a one-to-many relationship with blocks.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function blocks()
    {
        return $this->hasMany(Block::class);
    }
}
