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
        'age' => 'Grupe de vârstă',
        'gender' => 'Genuri',
        'location' => 'Locații',
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
        'segments' => 'pe :segments',
    ],

    'indicator' => [
        'label' => [
            'beneficiaries' => 'Beneficiari (număr)',
            'vulnerabilities' => 'Vulnerabilități (număr)',
        ],
        'value' => [
            'beneficiaries' => [
                'total' => 'Total beneficiari',
                'registered' => 'Beneficiari înregistrați',
                'catagraphed' => 'Beneficiari catagrafiați',
                'active' => 'Beneficiari activi',
                'inactive' => 'Beneficiari inactivi',
                'removed' => 'Beneficiari scoși din evidență',
                'ocasional' => 'Beneficiari ocazionali',
            ],
            'vulnerabilities' => [
                'catagraphy_total' => 'Total catagrafii',
                'catagraphy_new' => 'Catagrafii noi create',
                'catagraphy_updated' => 'Catagrafii actualizate/ modificate',
                'vulnerability_active_total' => 'Total vulnerabilități active',
                'vulnerability_new' => 'Vulnerabilități nou identificate',
                'beneficiary_vulnerable' => 'Beneficiari vulnerabili (minim o vulnerabilitate)',
                'beneficiary_nonvulnerable' => 'Beneficiari catagrafiați fără nicio vulnerabilitate',
            ],
        ],
    ],

    'segment' => [
        'label' => [
            'age' => 'Grupe de vârstă beneficiar',
            'gender' => 'Gen beneficiar',
        ],
        'value' => [
            'age' => [
                'VCV_01' => '0-1 ani',
                'VCV_02' => '1-5 ani',
                'VCV_03' => '5-14 ani',
                'VCV_04' => '14-18 ani',
                'VCV_05' => '18-65 ani',
                'VCV_06' => 'peste 65 ani',
                'total' => 'Total',
            ],
            'gender' => [
                'male' => 'Masculin',
                'female' => 'Feminin',
                'other' => 'Altul',
                'total' => 'Total',
            ],
        ],
    ],

];
