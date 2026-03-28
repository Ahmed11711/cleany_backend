<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    */

    // دمجنا كل المسارات في مصفوفة واحدة، وضفنا tracking/* عشان الـ Redis
    'paths' => [
        'api/*',
        'tracking/*',
        'storage/*',
        'sanctum/csrf-cookie'
    ],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'http://localhost:3000',
        'http://127.0.0.1:3000'
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    // لو بتستخدم Sanctum (Tokens/Cookies) خلي دي true
    'supports_credentials' => true,

];
