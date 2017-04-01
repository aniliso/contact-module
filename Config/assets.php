<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Define which assets will be available through the asset manager
    |--------------------------------------------------------------------------
    | These assets are registered on the asset manager
    */
    'contact-partial-assets'          => [
        'jquery.fileupload.css' => ['module' => 'contact:css/jquery.fileupload.css'],
        'jquery.fileupload.js'      => ['module' => 'contact:js/jquery.fileupload.js'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Define which default assets will always be included in your pages
    | through the asset pipeline
    |--------------------------------------------------------------------------
    */
    'contact-partial-required-assets' => [
        'css' => [
            'jquery.fileupload.css',
        ],
        'js' => [
            'jquery.fileupload.js',
        ],
    ],
];