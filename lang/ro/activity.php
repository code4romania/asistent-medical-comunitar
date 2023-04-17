<?php

declare(strict_types=1);

return [

    'label' => 'Istoric modificări',

    'column' => [
        'created_at' => 'Data',
        'causer' => 'AMC',
        'section' => 'Secțiune',
        'change' => 'Modificare',
        'event' => 'Eveniment',
    ],

    'event' => [
        'created' => 'Creat',
        'updated' => 'Modificat',
        'deleted' => 'Șters',
    ],

    'filter' => [
        'event_created' => 'Creare',
        'event_updated' => 'Modificare',
        'event_deleted' => 'Ștergere',
        'logged_from' => 'Înregistrat de la',
        'logged_until' => 'Înregistrat până la',
    ],

    'indicator' => [
        'logged_from' => 'După :date',
        'logged_until' => 'Până la :date',
    ],

    'no_causer' => 'Automat (sistem)',

    'beneficiary' => [
        'default' => 'Date personale',
        'catagraphy' => 'Catagrafie',
    ],
];
