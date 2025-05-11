<?php

return [
    'secret' => env('RECAPTCHA_SITE_SECRET'),
    'sitekey' => env('RECAPTCHA_SITE_KEY'),
    'options' => [
        'timeout' => 30,
    ],
];
