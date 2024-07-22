<?php

declare(strict_types=1);

return [

    'label' => [
        'singular' => 'raport',
        'plural' => 'rapoarte',
    ],

    'header' => [
        'list' => 'Rapoarte',
        'coming_soon' => 'Disponibile în curând.',
    ],

    'notification' => [
        'saved' => 'Raportul a fost salvat cu succes',
        'failed' => 'Raportul nu a putut fi salvat',
    ],

    'section' => [
        'standard' => 'Rapoarte standard',
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

    'standard_type' => [
        'GENERAL' => 'Asistent medical comunitar (Fişa generală)',
        'PREGNANT' => 'Gravidă (fişă raportare)',
        'CHILD' => 'Copil (fişă raportare)',
        'RARE_DISEASE' => 'Asistent medical comunitar (fişă raportare boli rare)',
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
            'general_record' => 'Fișă generală',
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
            'general_record' => [
                'adult_no_medicosocial' => 'Adult (fără probleme medicosociale)',
                'adult_with_cronic_illness' => 'Adult cu boli cronice',
                'adult_with_disabilities' => 'Adult cu dizabilități',
                'adult_without_family' => 'Adult fără familie',
                'familiy_with_domestic_violence_case' => 'Caz de violență în familie',
                'woman_fertile_age' => 'Femeie de vârstă fertilă (15-45 de ani)',
                'woman_postpartum' => 'Lăuză',
                'underage_mother' => 'Mamă minoră',
                'family_planning' => 'Planificare familială',
                'person_without_gp' => 'Persoană neînscrisă la medicul de familie',
                'elderly' => 'Vârstnic (peste 65 de ani)',
                'elderly_without_family' => 'Persoană vârstnică fără familie',
                'elderly_with_cronic_illness' => 'Vârstnic cu boli cronice',
                'elderly_with_disabilities' => 'Vârstnic cu dizabilități',
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
