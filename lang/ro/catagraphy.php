<?php

declare(strict_types=1);

return [

    'label' => [
        'singular' => 'catagrafie',
        'plural' => 'catagrafii',
    ],

    'header' => [
        'vulnerabilities' => 'Sumar vulnerabilități',
        'recommendations' => 'Recomandări',
    ],

    'id_type' => [
        'VAI_01' => 'Copil sub 14 ani fără certificat de naștere',
        'VAI_02' => 'Adult sau copil peste 14 ani fără CI',
        'VAI_99' => 'Deține act de identitate',
    ],

    'age_category' => [
        'VCV_01' => 'Copil 0-1 ani',
        'VCV_02' => 'Copil 1-5 ani',
        'VCV_03' => 'Copil 5-14 ani',
        'VCV_04' => 'Adolescent 14-18 ani',
        'VCV_05' => 'Adult 18-65 ani',
        'VCV_06' => 'Vârstnic peste 65 ani',
    ],

    'income' => [
        'VSV_01' => 'Fără venit, fără beneficii sociale',
        'VSV_02' => 'Beneficiază de VMG sau ASF (beneficii sociale)',
        'VSV_99' => 'Fără vulnerabilități financiare observate',
    ],

    'poverty' => [
        'VGS_01' => 'Sărăcie',
        'VGS_02' => 'Sărăcie extremă',
        'VGS_99' => 'Fără sărăcie observată',
    ],

    'habitation' => [
        'VLP_03' => 'Fără locuință',
        'VLP_01' => 'Condiții nesănătoase',
        'VLP_02' => 'Supraaglomerare',
        'VLP_99' => 'Fără locuire precară observată',
    ],

    'family' => [
        'VFC_01' => 'Copil cu un singur părinte acasă',
        'VFC_02' => 'Copil din familiei cu părinți migranți',
        'VFC_03' => 'Copil fără ambii părinți acasă, dar cu îngrijitor adult în gospodărie',
        'VFC_04' => 'Copil care nu are un îngrijitor adult în gospodărie',
        'VFC_05' => 'Copil în plasament sau asistență maternală în condiții de risc',
        'VFC_06' => 'Copil cu risc de separare de familie',
        'VFA_01' => 'Adult sau vârstnic fără familie',
        'VFA_02' => 'Vârstnic care locuiește singur',
        'VFCA_99' => 'Fără vulnerabilitate familială observată',
    ],

    'education' => [
        'VEC_01' => 'Copil de vârstă antepreșcolară (sub 3 ani) neînscris la creșă',
        'VEC_02' => 'Copil de vârstă preșcolară (3-6 ani) neînscris la grădiniță',
        'VEC_03' => 'Copil (6-10 ani) neînscris la școală',
        'VEC_04' => 'Copil (11-15 ani) neînscris la școală',
        'VEC_05' => 'Copil cu risc de abandon școlar',
        'VEC_06' => 'Copil cu risc de abandon școlar, care are cerințe educaționale speciale',
        'VEC_07' => 'Copil care a abandonat școala',
        'VEA_01' => 'Adult analfabet',
        'VECA_99' => 'Fără vulnerabilitate educațională observată',
    ],

    'domestic_violence' => [
        'VFV_01' => 'Risc de violență sau abuz în familie',
        'VFV_02' => 'Copil în familie cu risc de neglijare a copiilor',
        'VFV_03' => 'Violență în familie',
        'VFV_04' => 'Abuz în familie',
        'VFV_99' => 'Fără risc de abuz sau violență observată',
    ],

    'social_health_insurance' => [
        'VSA_01' => 'Neasigurat',
        'VSA_98' => 'Coasigurat',
        'VSA_99' => 'Asigurat',
    ],

    'family_doctor' => [
        'VSA_02' => 'Neînscris la medic de familie',
        'VSA_99' => 'Înscris la medic de familie',
    ],

    'disability' => [
        'VDH_01' => 'Dizabilitate cu certificat',
        'VDH_02' => 'Dizabilitate fără certificat',
        'VDH_99' => 'Fără dizabilitate raportată',
    ],

];