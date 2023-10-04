<?php

namespace App\Applications\User\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Shanmuga\LaravelEntrust\Models\EntrustPermission;

class Permission extends EntrustPermission
{
    use HasFactory;

    protected $fillable = ['name', 'display_name', 'description' ];
}
