<?php

declare(strict_types=1);

return [

    'label' => [
        'singular' => 'utilizator',
        'plural' => 'Utilizatori',
    ],

    'profile' => [
        'my_profile' => 'Profilul meu',

        'section' => [
            'general' => 'Informații generale',
            'studies' => 'Studii și cursuri',
            'courses' => 'Cursuri',
            'employers' => 'Angajatori',
            'area' => 'Arie acoperită',
        ],
    ],

    'section' => [
        'nurses' => 'Asistenți medicali comunitari',
        'coordinators' => 'Coordonatori județeni',
        'admins' => 'Admin MS',
    ],

    'role' => [
        'admin' => 'Admin MS',
        'coordinator' => 'Coordonator județean',
        'nurse' => 'Asistent medical comunitar',
    ],

    'status' => [
        'active' => 'Activ',
        'inactive' => 'Inactiv',
        'invited' => 'Invitat',
    ],

    'inactive_error' => 'Contul tău nu este activ. Pentru mai multe detalii te rugăm să contactezi un administrator.',

    'action' => [
        'create' => 'Creează cont utilizator',
        'invite' => 'Invită utilizator',
        'activate' => 'Activează cont utilizator',
        'deactivate' => 'Dezactivează cont utilizator',
        'resend_invitation' => 'Retrimite invitația',
        'manage_profile' => 'Gestionează profil',
    ],

    'action_activate_confirm' => [
        'title' => 'Activează cont utilizator',
        'text' => 'Ești sigur că vrei să activezi acest utilizator?',
        'action' => 'Activează',
        'success' => 'Utilizatorul a fost activat cu succes.',
    ],

    'action_deactivate_confirm' => [
        'title' => 'Dezactivează cont utilizator',
        'text' => 'Ești sigur că vrei să dezactivezi acest utilizator?',
        'action' => 'Dezactivează',
        'success' => 'Utilizatorul a fost dezactivat cu succes.',
    ],

    'action_resend_invitation_confirm' => [
        'title' => 'Retrimite invitația pe email',
        'text' => 'Ești sigur că vrei să retrimiți invitația acest utilizator? Poți retrimite invitația doar o dată pe oră.',
        'action' => 'Trimite',
        'success' => 'Invitația a fost trimisă cu succes.',
        'failure_title' => 'Invitația nu a putut fi trimisă.',
        'failure_body' => 'Acestui utilizator i-a fost retrimisă invitația recent. Te rugăm să mai încerci peste o oră.',
    ],

];
