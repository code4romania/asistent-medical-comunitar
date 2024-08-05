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

    'no-results' => [
        'title' => 'Fără date',
        'description' => 'Nu am găsit date pentru raportul și intervalul selectate.',
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
        'category' => 'Categorie',
        'period' => 'Perioada de raportare',
    ],

    'type' => [
        'list' => 'Listă',
        'statistic' => 'Statistic',
    ],

    'standard' => [
        'category' => [
            'general' => 'Asistent medical comunitar (fișă generală)',
            'pregnant' => 'Gravidă (fișă raportare)',
            'child' => 'Copil (fișă raportare)',
            'rare_disease' => 'Asistent medical comunitar (fișă raportare boli rare)',
        ],

        'indicator' => [
            'general' => [
                'G01' => 'Femeie de vârstă fertilă (15-45 de ani)',
                'G02' => 'Femeie care utilizează metode contraceptive',
                'G03' => 'Vârstnic (peste 65 de ani)',
                'G04' => 'Persoană neînscrisă la medicul de familie',
                'G05' => 'Caz de violență în familie',
                'G06' => 'Persoană vârstnică fără familie',
                'G07' => 'Persoană vârstnică cu nevoi medicosociale',
                'G08' => 'Adult cu TBC',
                'G09' => 'Adult cu HIV/SIDA',
                'G10' => 'Adult cu dizabilități',
                'G11' => 'Administrare de medicamente pentru persoane vulnerabile',
                'G12' => 'Adult cu risc medicosocial',
                'G13' => 'Adult fără familie',
                'G14' => 'Adult cu boli cronice',
                'G15' => 'Vârstnic cu boli cronice',
                'G16' => 'Vârstnic cu TBC',
                'G17' => 'Vârstnic cu dizabilități',
                'G18' => 'Vârstnic cu tulburări mintale și de comportament',
                'G19' => 'Vârstnic consumator de substanțe psihotrope',
                'G20' => 'Adult cu tulburări mintale și de comportament',
                'G21' => 'Adult consumator de substanțe psihotrope',
                'G22' => 'Mamă minoră',
                'G23' => 'Lăuză',
                'G24' => 'Adult (fără probleme medicosociale)',
                'G25' => 'Anunțare pentru screening populațional',
                'G26' => 'Caz tratament paliativ (fază terminală)',
                'G27' => 'Planificare familială',
                'G28' => 'Consiliere preconcepțională',
            ],

            'pregnant' => [
                'P01' => 'Gravidă cu probleme sociale',
                'P02' => 'Gravidă cu probleme medicale (sarcină cu risc)',
                'P03' => 'Gravidă care a efectuat consultaţii prenatale',
                'P04' => 'Avort spontan',
                'P05' => 'Avort medical',
                'P06' => 'Naştere înregistrată la domiciliu',
                'P07' => 'Gravidă minoră',
                'P08' => 'Gravidă neînscrisă la medicul de familie',
                'P09' => 'Gravidă înscrisă de asistentul medical comunitar/moaşă la medicul de familie',
                'P10' => 'Gravidă consiliată',
                'P11' => 'Diagnosticare precoce a sarcinii',
                'P12' => 'Îngrijiri prescrise de medic',
            ],
        ],
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
