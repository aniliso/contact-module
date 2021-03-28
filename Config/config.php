<?php

return [
    'name'              => 'Contacts',
    'fields'            => [
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
        'subject'    => [
            'type' => 'dropdown'
        ],
        'enquiry'    => [
            'type' => 'textarea',
        ],
    ],
    'rules'             => [
        'first_name'           => 'required',
        'last_name'            => 'required',
        'phone'                => 'required',
        'email'                => 'required|email',
        'subject'              => 'required',
        'enquiry'              => 'required',
        'g-recaptcha-response' => 'required|captcha'
    ],
    'api_rules'         => [
        'first_name'      => 'required',
        'last_name'       => 'required',
        'phone'           => 'required',
        'email'           => 'required|email',
        'subject'              => 'required',
        'enquiry'         => 'required',
        'captcha_contact' => 'required|captcha'
    ],
    'api_call_rules'    => [
        'first_name' => 'required',
        'last_name'  => 'required',
        'phone'      => 'required',
        'email'      => 'required|email',
        'enquiry'    => 'required'
    ],
    'mail'              => [
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
        'backend-theme'  => false,
        // Read module views from /Themes/<frontend-theme-name>/views/modules/<module-name>
        'frontend-theme' => true,
        // Read module views from /resources/views/<module-name>
        'resources'      => true,
    ],

    'subjects' => [
        trans('themes::contact.subjects.complaint')   => 'geribildirim@ykenerji.com.tr',
        trans('themes::contact.subjects.info')        => 'info@ykenerji.com.tr',
        trans('themes::contact.subjects.other')       => 'info@ykenerji.com.tr',
        trans('themes::contact.subjects.hr')          => 'ykk.ik@ykenerji.com.tr',
        trans('themes::contact.subjects.purchasing')  => 'info.satinalma@ykenerji.com.tr',
        trans('themes::contact.subjects.accounting')  => 'info.muhasebe@ykenerji.com.tr',
        trans('themes::contact.subjects.environment') => 'cevre@ykenerji.com.tr',
        trans('themes::contact.subjects.operation')   => 'info.isletme@ykenerji.com.tr',
        trans('themes::contact.subjects.corporate')   => 'canan.baykiz@ykenerji.com.tr'
    ]
];
