<?php

declare(strict_types=1);

return [

    'label' => [
        'singular' => 'programare',
        'plural' => 'Programări',
    ],

    'header' => [
        'view' => 'Programare :beneficiary - :date, :start_time',
    ],

    'section' => [
        'mandatory' => 'Detalii obligatorii',
        'additional' => 'Detalii adiționale',
        'notes' => 'Observații programare',
        'index' => 'Listă',
        'calendar' => 'Calendar',
    ],

    'empty' => [
        'title' => 'Nicio programare înregistrată',
        'description' => 'Odată înregistrate programări în baza de date, acestea vor fi afișate în acest tabel.',
    ],

    'empty_upcoming' => [
        'title' => 'Nicio programare viitoare',
    ],

    'action' => [
        'create' => 'Adaugă programare',
        'edit' => 'Editează programare',
        'update' => 'Actualizează programare',
        'delete' => 'Șterge programare',
    ],
];
