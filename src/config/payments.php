<?php
return [

    /*
    |----------------------------------------------
    | set type payment [ریال = rtr] [ تومان = rtt]
    |-----------------------------------------------
    */
    'currency' => 'rtt',

    /*
     |-------------------------------------------------
     |
     |-------------------------------------------------
     */

    'http_verify' => true,
    /*
    |--------------------------------------------
    | set default payment
    |--------------------------------------------
    | from 'Zibal', 'PayIr', 'IdPay', 'Zarinpal'
    */

    'Default_payment' => 'Zibal',

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
            'key' => 'ee73132b-de63-453d-a96f-7843c7266d9e',
            'access_Token' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiOWRiNzIzNzhiNmE4NGI1YWU2ZWUxZjhhZWZiNjRmN2JlYzM4MTQ0NTEwYzU4YmQ4NGEzMmFkYWI0YTM5MmQ0ZTQyOTk3NTA4OGZlMjQwOTMiLCJpYXQiOjE2NTUwNTQ2ODUuMDIzNzc5LCJuYmYiOjE2NTUwNTQ2ODUuMDIzNzgzLCJleHAiOjE4MTI4MjEwODUuMDA4ODk0LCJzdWIiOiIzODkxMjgiLCJzY29wZXMiOltdfQ.MPv65G15nY7SPJYh4Wgsdws-UA9oM9D_2gnDwvHJMgbkDZkLd8SVt0H0s6oZmMUIZnxLHb6CSPlLfLD6p6PsaKsDgP1kjGIT-2719oCT7WVMyLGwz8pJmpwup6GXvlYFxcYI2ujl3k2249IDpb-wFMuLfYM3IWXi_jOxhzW62SvjRdGrRN3omC2qEnt3phmf_8f5JEk1bct-XFifWz6XVZ2KY278UNEgnkPC7Nb_48oAmYoZQ5iBd2fn4nOOOUuSr19p10j0xGgGH-QbEDsQ1CSOoaiuZw8UL9z_9lvzDq_LC9Vls4sQd5DzMfmvLLnoN0AS8LORHuSvUDkF_INhEmc7FSlSgZfVWyrPGctTUXc441xGWHMCmTyEJH9pa0ILppEhsl2kMREf8kK2jgTet3H5jZfoP6q0U9IMC2abs_lY-h1zkkVXsVjRaCZndPNFYvP4BczphPQcRak-EFYqI59jqjPrZqya_60LAJNnDqrRFHjylBiYB_hPy2nTg2JBRhSTCiOMTgWUf_5x_-WwkBuH9xFlLVlp9qAQOBhqIm6nT9hWp5B4-SQy-X9plp8YaGg67IncSOKO-SwMVmbZLdsWp5CNRfSI6ZOT4A61oIc6RW-vNt141DdgYZ5I-583Iqe5-Plt6skfltVcawA_Ni_zJ-lE3qPlw5llgMtvs0Y',
            'status' => true
        ],

        'Zibal' =>  [
            'key' => 'ee73132b-de63-453d-a96f-7843c7266d9e',
            'status' => true
        ],

        'PayIr' =>  [
            'key' => 'ee73132b-de63-453d-a96f-7843c7266d9e',
            'status' => true
        ],

        'IdPay' =>  [
            'key' => 'ee73132b-de63-453d-a96f-7843c7266d9e',
            'status' => true
        ],
    ]
];
