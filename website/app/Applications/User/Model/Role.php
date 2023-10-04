<?php

namespace App\Applications\User\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Shanmuga\LaravelEntrust\Models\EntrustRole;

class Role extends EntrustRole
{
    use HasFactory;

    const ADMIN = 'administrator';
    const COLLABORATOR = 'collaborator';
    const PUBLIC = 'public';

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
