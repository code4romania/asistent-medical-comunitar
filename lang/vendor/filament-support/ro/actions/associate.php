<?php

declare(strict_types=1);

return [

    'single' => [

        'label' => 'Asociază',

        'modal' => [

            'heading' => 'Asociază :label',

            'fields' => [

                'record_id' => [
                    'label' => 'Înregistrare',
                ],

            ],

            'actions' => [

                'associate' => [
                    'label' => 'Asociază',
                ],

                'associate_another' => [
                    'label' => 'Asociați și asociați altul',
                ],

            ],

        ],

        'messages' => [
            'associated' => 'Asociat cu succes',
        ],

    ],

];
