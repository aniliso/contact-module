<?php

return [
    'name'   => 'Contacts',
    'fields' => [
        'first_name' => [
            'type' => 'text',
        ],
        'last_name'  => [
            'type' => 'text',
        ],
        'email'      => [
            'type' => 'text',
        ],
        'phone'      => [
            'type' => 'text',
        ],
        'enquiry'    => [
            'type' => 'textarea',
        ],
    ],
    'rules'  => [
        'first_name'           => 'required',
        'last_name'            => 'required',
        'phone'                => 'required',
        'email'                => 'required|email',
        'enquiry'              => 'required',
        'captcha_contact'      => 'required|captcha'
    ],
    'mail'   => [
        'views' => [
            'contact::emails.html.enquiry',
            'contact::emails.text.enquiry',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Load additional view namespaces for a module
    |--------------------------------------------------------------------------
    | You can specify place from which you would like to use module views.
    | You can use any combination, but generally it's advisable to add only one,
    | extra view namespace.
    | By default every extra namespace will be set to false.
    */
    'useViewNamespaces' => [
        // Read module views from /Themes/<backend-theme-name>/views/modules/<module-name>
        'backend-theme' => false,
        // Read module views from /Themes/<frontend-theme-name>/views/modules/<module-name>
        'frontend-theme' => true,
        // Read module views from /resources/views/<module-name>
        'resources' => true,
    ],
];
