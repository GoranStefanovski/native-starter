<?php

namespace App\Applications\PageBuilder\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Block
 *
 * Represents a block associated with a container in the PageBuilder application.
 *
 * @package App\Applications\PageBuilder\Model
 */
class Block extends Model
{
    protected $table = 'blocks';
    protected $fillable = ['container_id', 'content', 'component'];
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Define a many-to-one relationship with the parent container.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function container()
    {
        return $this->belongsTo(Container::class);
    }
}
