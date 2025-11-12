<?php

declare(strict_types=1);

return [

    'single' => [

        'label' => 'Atașează',

        'modal' => [

            'heading' => 'Atașează :label',

            'fields' => [

                'record_id' => [
                    'label' => 'Înregistrare',
                ],

            ],

            'actions' => [

                'attach' => [
                    'label' => 'Atașează',
                ],

                'attach_another' => [
                    'label' => 'Atașează și atașează altul',
                ],

            ],

        ],

        'messages' => [
            'attached' => 'Atașat cu succes',
        ],

    ],

];
