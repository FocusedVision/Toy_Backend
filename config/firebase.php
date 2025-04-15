<?php

declare(strict_types=1);

return [
  
    'default' => env('FIREBASE_PROJECT', 'empettoy'),


    'projects' => [
        'empettoy' => [

            'credentials' => env('FIREBASE_CREDENTIALS'),
            'database' => [
                'url' => env('FIREBASE_DATABASE_URL'),
            ],
        ],
    ],
];