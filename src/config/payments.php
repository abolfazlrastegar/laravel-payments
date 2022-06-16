<?php
return [

    /*
    |----------------------------------------------
    | set type payment [ریال = rtr] [ تومان = rtt]
    |-----------------------------------------------
    */
    'currency' => 'rtt',

    /*
    |--------------------------------------------
    | set default payment
    |--------------------------------------------
    | from 'Zibal', 'PayIr', 'IdPay', 'Zarinpal'
    */

    'Default_payment' => 'IdPay',

    /*
    |-------------------------------------------
    | set description payment
    |-------------------------------------------
    */
    'Description_payment' => 'شارژ کیف پول',

    /*
    |-------------------------------------------
    | set description payment
    |-------------------------------------------
    */
    'Test_payment' => false,

    /*
     |------------------------------------------
     | active and inactive Bank portal
     |------------------------------------------
     | active = 'true'  and inactive = 'false'
     */
    'drivers' => [
        'Zarinpal' => [
            'key' => '',
            'access_Token' => '',
            'status' => true,
            'api_test_request' => 'https://sandbox.zarinpal.com/pg/v4/payment/request.json',
            'api_test_py' => 'https://sandbox.zarinpal.com/pg/StartPay/',
            'api_test_verify' => 'https://sandbox.zarinpal.com/pg/v4/payment/verify.json',
        ],

        'Zibal' =>  [
            'key' => '',
            'status' => true
        ],

        'PayIr' =>  [
            'key' => '',
            'status' => true
        ],

        'IdPay' =>  [
            'key' => '',
            'status' => true
        ],
    ]
];
