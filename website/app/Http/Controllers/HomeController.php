<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('app');
    }


    /**
     * Show the admin application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function indexAdmin()
    {
        return view('app_admin');
    }

    /**
     * Run an artisan command from url (used for debugging)
     *
     * @return void
     */
    public function runCommand($command)
    {
        Artisan::call($command);
    }

    /**
     * Get initial data for Vue.js application
     */
    public function vue()
    {
        $mainMenu = [
            [
                'label' => 'strings.dashboard',
                'name' => 'item_dashboard',
                'link' => 'dashboard',
                'permission' => 'read-users', // Change to dashboard_view
            ],
            [
                'label' => 'strings.users.main',
                'name' => 'item_users',
                'link' => 'users',
                'expanded' => false,
                'permission' => 'read-users',
                'subcategories' => [
                    [
                        'label' => 'strings.users.admin',
                        'name' => 'item_users',
                        'link' => 'users',
                        'permission' => 'read-users',
                    ],
                    [
                        'label' => 'strings.users.public',
                        'name' => 'item_users_public',
                        'link' => 'users.public',
                        'permission' => 'read-users',
                    ],
                ]
            ],
            [
                'label' => 'pages.menu.label',
                'name' => 'pages',
                'link' => 'pages',
                'expanded' => false,
                'permission' => 'read-users',
            ],
            [
                'label' => 'components.label',
                'name' => 'components',
                'link' => 'components',
                'expanded' => false,
                'permission' => 'read-users',
                'subcategories' => [
                    [
                        'label' => 'components.portlets.label',
                        'name' => 'components.portlets',
                        'link' => 'components.portlets',
                        'permission' => 'read-users',
                    ],
                    [
                        'label' => 'components.buttons.label',
                        'name' => 'components.buttons',
                        'link' => 'components.buttons',
                        'permission' => 'read-users',
                    ]
                ]
            ]
        ];

        $data = [
            'mainMenu' => $mainMenu,
        ];

        return $data;
    }
}
