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
        'name' => 'Nume raport',
        'indicators' => 'Indicatori',
        'segmentation' => 'Segmentare',
    ],

    'type' => [
        'nurse_activity' => 'Activitate AMC',
        'vuln_total' => 'Vulnerabilități (Totaluri)',
        'vuln_list' => 'Vulnerabilități (Liste)',
        'health_total' => 'Stare de sănătate (Totaluri)',
        'health_list' => 'Stare de sănătate (Liste)',
    ],

];
