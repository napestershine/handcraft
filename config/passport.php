<?php

return [
    'expiry' => [
        'access_token' => \Carbon\Carbon::now()->addDays(3),
        'refresh_token' => \Carbon\Carbon::now()->addDays(3),
    ]
];