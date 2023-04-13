<?php

declare(strict_types=1);

return [

    'label' => [
        'singular' => 'beneficiar',
        'plural' => 'beneficiari',
    ],

    'header' => [
        'id' => 'Date identificare',
        'list' => 'Listă beneficiari',
    ],

    'status' => [
        'registered' => 'Înregistrat',
        'catagraphed' => 'Catagrafiat',
        'active' => 'Activ',
        'inactive' => 'Inactiv',
        'removed' => 'Scos din evidență',
    ],

    'integrated' => [
        'yes' => 'Da (echipă comunitară)',
        'no' => 'Nu (doar AMC)',
    ],

    'type' => [
        'regular' => 'Beneficiar propriu',
        'ocasional' => 'Beneficiar ocazional',
    ],

    'id_type' => [
        'birth_certificate' => 'Certificat de naștere',
        'id_card' => 'Carte de identitate',
        'national_passport' => 'Pașaport Românesc',
        'foreign_passport' => 'Pașaport Străin',
        'other' => 'Alt act de identitate',
        'none' => 'Nu deține act de identitate',
    ],

    'section' => [
        'index' => 'Toți beneficiarii',
        'regular' => 'Beneficiari proprii',
        'ocasional' => 'Beneficiari ocazionali',
        'households' => 'Gospodării',
        'personal_data' => 'Date personale',
        'active_interventions' => 'Intervenții active',
        'catagraphy' => 'Catagrafie',
        'program' => 'Program AMC',
    ],

    'action_convert' => [
        'title' => 'Tip beneficiar',
        'text_line_1' => 'Beneficiarul este de tip **beneficiar ocazional**.',
        'text_line_2' => 'Doriți să modificați tipul beneficiarului în beneficiar propriu?',
        'action' => 'Modifică tipul beneficiarului',
    ],

    'action_convert_confirm' => [
        'title' => 'Modifică tipul beneficiarului din ocazional în propriu',
        'text' => 'Dacă beneficiarul ocazional este luat în evidență ca beneficiar propriu, tipul acestuia poate fi modificat pentru a accesa fișa extinsă. Informațiile salvate până acum vor fi păstrate dar acțiunea nu este reversibilă.',
        'action' => 'Modifică',
    ],

    'empty' => [
        'title' => 'Niciun beneficiar înregistrat',
        'description' => 'Odată înregistrați beneficiari în baza de date, aceștia vor fi afișați în acest tabel',
        'create' => 'Adaugă primul beneficiar',
    ],

    'action' => [
        'create' => 'Adaugă beneficiar',
        'edit' => 'Editează beneficiar',
        'update' => 'Actualizează beneficiar',
        'delete' => 'Șterge beneficiar',
        'view_details' => 'Vezi detalii',
    ],

];
