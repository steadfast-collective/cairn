<?php

return [
    /**
     * Layout file to use
     * Default: resources/views/layout.antlers.html
     */
    'layout' => 'auth',

    /**
     * Default Statamic role/s for new users
     * Supply role handles, i.e 'admin', 'customer'
     */
    'default_roles' => [],

    /**
     * On login, if user has following roles, redirect to CP
     * Super admins will *always* be redirected to the CP
     */
    'cp_roles' => [],

    /**
     * Redirect after register / login
     * Please use route name
     */
    'redirect' => "auth.account.index",

    /**
     * Users can register.
     * Setting this to false will disable the register routes
     */
    'register' => [
        'enabled' => true,
        'prefix' => 'register',
    ],

    /**
     * Account area settings
     * setting 'enabled' to false will disable the account routes
     */
    'account' => [
        'enabled' => true,
        'prefix' => 'my-account',
        'layout' => 'layout',
        'users_can_delete_account' => true,
        'users_can_update_password' => true,
    ],

    /**
     * Two Factor authentication
     */
    'two_factor' => [
        'enabled' => true,
    ],

    /**
     * Password Rules
     * This is purely for frontend, for *actual* validation rules, see Password::defaults in AppServiceProvider
     */
    'rules' => [
        [
            'label' => 'Must be at least 8 characters',
            'condition' => "/^.{8,}$/",
        ],
        [
            'label' => 'Must contain one special character',
            'condition' => "/[^a-zA-Z0-9]/",
        ],
        [
            'label' => 'Must contain at least one letter',
            'condition' => "/[a-zA-Z]/",
        ],
        [
            'label' => 'Must contain at least one number',
            'condition' => "/[0-9]/",
        ],
    ]
];
