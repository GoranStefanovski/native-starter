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
                'permission' => 'user_view', // Change to dashboard_view
            ],
            [
                'label' => 'strings.users.main',
                'name' => 'item_users',
                'link' => 'users',
                'expanded' => false,
                'permission' => 'user_view',
                'subcategories' => [
                    [
                        'label' => 'strings.users.public',
                        'name' => 'item_users_public',
                        'link' => 'users.public',
                        'permission' => 'user_view',
                    ],
                ]
            ],
            // [
            //     'label' => 'pagebuilder.menu.label',
            //     'name' => 'page.builder',
            //     'link' => 'page.builder',
            //     'expanded' => false,
            //     'permission' => 'user_view',
            // ],
            // [
            //     'label' => 'components.label',
            //     'name' => 'components',
            //     'link' => 'components',
            //     'expanded' => false,
            //     'permission' => 'user_view',
            //     'subcategories' => [
            //         [
            //             'label' => 'components.portlets.label',
            //             'name' => 'components.portlets',
            //             'link' => 'components.portlets',
            //             'permission' => 'user_view',
            //         ],
            //     ]
            // ],
            [
                'label' => 'strings.locations.label',
                'name' => 'locations',
                'link' => 'locations',
                'expanded' => false,
                'permission' => 'locations_view',
            ],
            [
                'label' => 'strings.events.label',
                'name' => 'events',
                'link' => 'events',
                'expanded' => false,
                'permission' => 'events_view',
            ],
            [
                'label' => 'strings.organization_events.label',
                'name' => 'organization_events',
                'link' => 'organization_events',
                'expanded' => false,
                'permission' => 'organization_view',
            ],
        ];

        $data = [
            'mainMenu' => $mainMenu,
        ];

        return $data;
    }
}
