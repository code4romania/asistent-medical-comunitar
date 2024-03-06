<?php

declare(strict_types=1);

return [

    'invalid_signature' => 'Acest link nu are o semnătură validă.',
    'no_user' => 'Acest utilizator nu este valid.',
    'already_used' => 'Acest link a fost folosit deja.',

    'email' => [
        'subject' => 'Bine ai venit în platforma AMC-MSR!',
        'greeting' => 'Salut, :name!',
        'intro' => 'Felicitări! Contul tău a fost creat cu succes în platforma AMC-MSR.',
        'steps' => [
            'intro' => 'Pentru a-ți accesa contul, te rugăm să urmezi pașii de mai jos:',
            'set_password' => '1. Apasă pe butonul "Setează parola" de mai jos.',
            'login' => '2. După ce ai setat parola, te poți loga în platformă folosind adresa ta de email și noua parolă. ',
        ],
        'help' => [
            'nurse' => 'Dacă întâmpini nelămuriri sau ai nevoie de asistență, te rugăm să iei legătura cu coordonatorul județean.',
        ],
        'submit' => 'Setează parola',
        'salutation' => [
            'regards' => 'Cu drag',
            'signature' => 'Echipa AMC-MSR',
        ],
    ],

    'set_password' => [

        'greeting' => 'Bine ai venit, :name!',
        'intro' => 'Pentru a putea începe configurarea contului, este nevoie să introduci o parolă nouă. Noua parolă setată, împreună cu adresa de email transmisă vor reprezenta credențialele de intrare în cont.',

        'submit' => 'Setează parola',
    ],

    'onboarding' => [
        'heading' => 'Parolă salvată cu succes!',
        'intro' => 'La prima intrare în cont, îți vom solicia să îți configurezi contul tău AMC. Ar fi util să ai la îndemână următoarele informații și documente:',
        'documents' => [
            'Diploma/ Atestatul/ Certificatul AMC (în format digital, poză sau scan)',
            'Informații despre studiile sau cursurile absolvite (inclusiv furnizori, date de început sau absolvire)',
            'Informații despre angajatorul curent',
            'Informații despre angajatorii anteriori',
        ],
        'login' => 'Intră în cont',
    ],

];
