<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Custom Breadcrumbs
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom breadcrumbs.
    |
    */

    'custom' => [
        'configuration' => [
            'parentInfo' => 'সেটিংস',
            'childInfo' => [
                'basicInfo' => 'মৌলিক তথ্য',
                'additionalInfo' => 'অতিরিক্ত তথ্য',
                'contactInfo' => 'যোগাযোগের তথ্য',
                'globalInfo' => 'গ্লোবাল তথ্য'
            ]
        ],
        'user' => [
            'parentInfo' => 'ইউজার ম্যানেজমেন্ট',
            'childInfo' => [
                'index' => 'ইউজার',
                'create' => 'নতুন',
                'edit' => 'এডিট',
                'details' => 'ডিটেইলস',
                'profile' => 'প্রোফাইল'
            ]
        ],
        'role' => [
            'childInfo' => [
                'index' => 'রোল',
                'create' => 'নতুন',
                'edit' => 'এডিট',
                'details' => 'ডিটেইলস'
            ]
        ],
    ]
];
