<?php
use App\Applications\User\Model\Role;

return [
    'role_structure' => [
        Role::ADMIN => [
            'users' => 'c,r,u,d',
            'admin' => 'c,r,u,d',
            'profile' => 'r,d'
        ],
        Role::COLLABORATOR => [
            'users' => 'c,r,u',
            'profile' => 'r,u'
        ],
        Role::PUBLIC => [
            'profile' => 'r,u'
        ],
    ],
    'user_roles' => [
        Role::ADMIN => [
            [
                'username' => 'administrator',
                'email' => 'admin@example.com',
            ],
        ],
        Role::COLLABORATOR => [
            [
                'username' => 'collaborator',
                'email' => 'collaborator@example.com',
            ]
        ],
        Role::PUBLIC => 5
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
    ],
];
