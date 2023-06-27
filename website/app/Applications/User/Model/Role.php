<?php

namespace App\Applications\User\Model;

use App\Applications\User\Model\User;
use App\Applications\User\Model\Permission;

class Role
{
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
