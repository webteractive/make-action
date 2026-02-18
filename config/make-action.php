<?php

// config for Webteractive/MakeAction
return [

    /*
    |--------------------------------------------------------------------------
    | Default generation settings
    |--------------------------------------------------------------------------
    | Used when no --target / --path / --namespace / --method are provided.
    |
    | Examples:
    | php artisan make:action HealTheWorldAction
    | -> app/Actions/HealTheWorldAction.php
    | -> namespace App\Actions
    | -> method handle()
    */
    'default' => [
        'path' => app_path('Actions'),
        'namespace' => 'App\\Actions',
        'method' => 'handle',
    ],

    /*
    |--------------------------------------------------------------------------
    | Target aliases
    |--------------------------------------------------------------------------
    | Targets allow you to avoid typing deep paths repeatedly (monorepo-friendly).
    |
    | Usage:
    | php artisan make:action HealTheWorldAction --target=billing
    |
    | Precedence (highest -> lowest):
    |   1) CLI options: --path, --namespace, --method
    |   2) Target alias config (targets.<alias>)
    |   3) Default config (default.*)
    */
    'targets' => [

        // Example: default app target
        'app' => [
            'path' => app_path('Actions'),
            'namespace' => 'App\\Actions',
            // 'method' => 'handle', // optional override
        ],

        // Example: monorepo plugin target
        // 'billing' => [
        //     'path' => base_path('plugins/Billing/src/Actions'),
        //     'namespace' => 'Plugins\\Billing\\Actions',
        //     'method' => 'execute', // optional override per target
        // ],
    ],
];
