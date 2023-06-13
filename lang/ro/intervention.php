<?php

declare(strict_types=1);

return [

    'label' => [
        'singular' => 'intervenție',
        'plural' => 'Intervenții',
    ],

    'title' => [
        'case' => 'Management de caz: :name',
        'individual_service' => 'Serviciu individual: :name',
    ],

    'summary' => 'Sumar intervenție',
    'services' => 'Servicii',

    'action' => [
        'add_service' => 'Adaugă serviciu',
        'close' => 'Închide intervenție',
        'reopen' => 'Redeschide intervenție',
        'create' => 'Adaugă altă intervenție',
        'delete' => 'Șterge intervenție',
        'edit' => 'Editează',
        'export' => 'Exportă',
        'open_case' => 'Deschide caz',
        'view_case' => 'Vezi fișă',
        'view_individual' => 'Vezi serviciu',
    ],

    'empty' => [
        'title' => 'Nicio intervenție deschisă',
        'create' => 'Deschide intervenție',
    ],

    'type' => [
        'individual' => 'Serviciu individual',
        'case' => 'Management de caz',
        'ocasional' => 'Intervenție beneficiar ocazional',
    ],

    'status' => [
        'open' => 'Deschis',
        'closed' => 'Închis',
        'realized' => 'Realizat',
        'unrealized' => 'Nerealizat',
        'planned' => 'Planificat',
    ],

    'table' => [
        'interventions' => '{0}:value intervenții|{1}:value intervenție|[2,19]:value intervenții|[20,*]:value de intervenții',
        'services' => '{0}:value servicii realizate|{1}:value serviciu realizat|[2,19]:value servicii realizate|[20,*]:value de servicii realizate',
    ],

    'action_close_confirm' => [
        'title' => 'Închide intervenție',
        'text' => 'Ești sigur că dorești să efectuezi operaţia?',
        'action' => 'Închide',
        'success' => 'Intervenția a fost închisă',
    ],

    'action_reopen_confirm' => [
        'title' => 'Redeschide intervenție',
        'text' => 'Ești sigur că dorești să efectuezi operaţia?',
        'action' => 'Redeschide',
        'success' => 'Intervenția a fost redeschisă',
    ],

    'initiator' => [
        'nurse' => 'Inițiativă proprie',
        'gp' => 'Medicul de familie',
        'team' => 'Echipa comunitară',
        'dph' => 'DSP',
        'other' => 'Alta entitate sau organizație',
    ],
];
