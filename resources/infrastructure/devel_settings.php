<?php

return [
    'displayErrorDetails' => true,

    'pdo' => [
        'dsn' => 'pgsql:host=pgsql;port=5432;dbname=bicing_devel;user=postgres;password=postgres'
    ],

    'guzzle' => [
        'connectionTimeout' => 5,
        'requestTimeout' => 5
    ],

    'openStreetMap' => [
        'accessToken' => ''
    ],

    'archival' => [
        'secondsOld' => 3600    // 90*24*60*60 // 90 days
    ]
];
