<?php

return [


    'driver' => env('MAIL_DRIVER', 'smtp'),
    'host' => env('MAIL_HOST', 'smtp.gmail.com'),
    'port' => env('MAIL_PORT', 465),
    'from' => array('address' => 'test@gmail.com', 'name' => 'Pendaftaran Yudisium Fakultas Sains Teknologi Universitas Airlangga'),
    'encryption' => 'ssl',
    'username' => env('MAIL_USERNAME'),
    'password' => env('MAIL_PASSWORD'),
    'sendmail' => '/usr/sbin/sendmail -bs',
    'pretend' => false,
];
