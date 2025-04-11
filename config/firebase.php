<?php

return [

    'default' => env('FIREBASE_PROJECT', 'app'),

    'projects' => [
        'app' => [
            'credentials' => [
                'file' => env('FIREBASE_CREDENTIALS'),
                'auto_discovery' => true,
            ],
        ],
    ],

];
