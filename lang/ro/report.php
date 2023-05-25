<?php

declare(strict_types=1);

return [

    'label' => [
        'singular' => 'raport',
        'plural' => 'rapoarte',
    ],

    'header' => [
        'list' => 'Rapoarte',
    ],

    'section' => [
        'generator' => 'Generator rapoarte',
        'list' => 'Rapoarte salvate',
    ],

    'empty' => [
        'title' => 'Niciun raport înregistrat',
        'description' => 'Odată înregistrate în baza de date, rapoartele vor fi afișate în acest tabel',
        'create' => 'Generează primul raport',
    ],

    'column' => [
        'created_at' => 'Data generării raport',
        'type' => 'Tip raport',
        'title' => 'Nume raport',
        'indicators' => 'Indicatori',
        'segments' => 'Segmentare',
    ],

    'type' => [
        'nurse_activity' => 'Activitate AMC',
        'vuln_total' => 'Vulnerabilități (Totaluri)',
        'vuln_list' => 'Vulnerabilități (Liste)',
        'health_total' => 'Stare de sănătate (Totaluri)',
        'health_list' => 'Stare de sănătate (Liste)',
    ],

    'action' => [
        'cancel' => 'Resetează',
        'generate' => 'Generează raport',
        'export' => 'Exportă',
        'save' => 'Salvează raport',
    ],

    'title' => [
        'date' => 'la data :date',
        'date_range' => 'pentru perioada :from — :to',
    ],

    'indicator' => [
        'beneficiaries' => [
            'name' => 'Beneficiari',
            'value' => [
                'total' => 'Total beneficiari',
                'registered' => 'Beneficiari înregistrați',
                'catagraphed' => 'Beneficiari catagrafiați',
                'active' => 'Beneficiari activi',
                'inactive' => 'Beneficiari inactivi',
                'removed' => 'Beneficiari scoși din evidență',
                'ocasional' => 'Beneficiari ocazionali',
            ],
        ],
    ],

    'segment' => [
        'age' => [
            'value' => [
                'VCV_01' => 'Copil 0-1 ani',
                'VCV_02' => 'Copil 1-5 ani',
                'VCV_03' => 'Copil 5-14 ani',
                'VCV_04' => 'Adolescent 14-18 ani',
                'VCV_05' => 'Adult 18-65 ani',
                'VCV_06' => 'Vârstnic peste 65 ani',
            ],
        ],
        'gender' => [
            'value' => [
                'male' => 'Masculin',
                'female' => 'Feminin',
                'other' => 'Altul',
            ],
        ],
    ],

];
