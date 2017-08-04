<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Laravel CORS
     |--------------------------------------------------------------------------
     |
     | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
     | to accept any value.
     |
     */
    'supportsCredentials' => false,
    'allowedOrigins' => ['chrome-extension://cnbpcbkjcbfmbpfaojbacmdkjcgopcnl', 'privatelabelmastery.com'],
    'allowedHeaders' => ['Content-Type', 'X-Requested-With'],
    'allowedMethods' => ['POST'],
    'exposedHeaders' => [],
    'maxAge' => 0,
];

