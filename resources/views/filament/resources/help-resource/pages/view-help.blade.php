<x-filament::page>
    <div class="prose max-w-none">

        <section id="tipuri-de-utilizatori">
            <h1>Tipuri de utilizatori</h1>

            <ol class="list-[upper-alpha]">
                <li>Asistent Medical Comunitar</li>
                <li>
                    Angajator

                    <ol class="list-[lower-alpha]">
                        <li>Primărie</li>
                        <li>Direcție de Sănătate Publică</li>
                        <li>Ministerul Sănătății</li>
                        <li>Alt angajator</li>
                    </ol>
                </li>
                <li>Super Admin</li>

            </ol>
        </section>

        <hr>

        <section id="niveluri-de-acces-pentru-fiecare-tip-de-utilizator">
            <h1>Niveluri de acces pentru fiecare tip de utilizator.</h1>

            <p>
                În funcție de tipul de activitate pe care îl desfășoară, fiecare utilizator are acces diferit la
                funcțiunile aplicației AMC. Puteți vedea o imagine de ansamblu a nivelului de acces în platformă pentru
                fiecare tip de utilizator în tabelul de mai jos. Fiecare secțiune din tabelul de mai jos este detaliată
                în cadrul acestui manual de utilizare.
            </p>

            <table class="text-center table-fixed">
                <thead class="bg-gray-200">
                    <tr>
                        <th>SECTIUNE</th>
                        <th colspan="3">Nivel de acces</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th>AMC</th>
                        <th>ANGAJATOR</th>
                        <th>SUPER ADMIN</th>
                    </tr>
                </thead>
                <tr>
                    <td class="text-left">Onboarding</td>
                    <td> Da </td>
                    <td> Da </td>
                    <td> Nu </td>
                </tr>
                <tr>
                    <td class="text-left"> Panou de control </td>
                    <td> Da </td>
                    <td> Da </td>
                    <td> Da </td>
                </tr>
                <tr>
                    <td class="text-left"> Management Asistenți </td>
                    <td> Nu </td>
                    <td> Da </td>
                    <td> Da </td>
                </tr>
                <tr>
                    <td class="text-left"> Beneficiari </td>
                    <td> Da </td>
                    <td> Nu </td>
                    <td> Partial </td>
                </tr>
                <tr>
                    <td class="text-left"> Programări </td>
                    <td> Da </td>
                    <td> Nu </td>
                    <td> Parțial </td>
                </tr>
                <tr>
                    <td class="text-left"> Activități comunitare </td>
                    <td> Da </td>
                    <td> Da </td>
                    <td> Da </td>
                </tr>
                <tr>
                    <td class="text-left"> Rapoarte </td>
                    <td> Da </td>
                    <td> Da </td>
                    <td> Da </td>
                </tr>
                <tr>
                    <td class="text-left"> Profil </td>
                    <td> Da </td>
                    <td> Da </td>
                    <td> Da </td>
                </tr>
                <tr>
                    <td class="text-left"> Setări </td>
                    <td> Da </td>
                    <td> Da </td>
                    <td> Da </td>
                </tr>
                <tr>
                    <td class="text-left"> Manual de utilizare </td>
                    <td> Da </td>
                    <td> Da </td>
                    <td> Da </td>
                </tr>
            </table>
        </section>

        <hr>

        <section id="arhitectura-informationala">
            <h1>Arhitectura informațională</h1>

            <p>Arhitectura informațională a aplicației este divizată în câteva module umbrelă: Beneficiari, Activități
                Comunitare, Rapoarte, Setări de profil.</p>
        </section>

        <section id="meniurile-aplicatiei">
            <h2>Meniurile aplicației</h2>

            <ol>
                <li>
                    <strong>Meniul principal</strong>: acest meniu ajută la navigarea printre modulele principale ale
                    aplicației. Oriunde te-ai afla în interiorul aplicației, acest meniu te ajută să revii la pagina
                    principală a fiecărui modul. În extrema dreaptă a meniului principal se află un meniu secundar
                    utilitar, care te ajută să ajungi la setările contului tău din aplicație precum și la opțiunea de
                    Delogare din sistem.</span>

                    <img
                        src="{{ Vite::asset('resources/images/help/image14.png') }}"
                        class="w-full"
                        alt=""
                    />
                </li>

                <li>
                    <strong>Meniul secundar</strong>: Odată ce ai ajuns pe profilul unui beneficiar vei putea să
                    utilizezi meniul secundar vertical, din partea stîngă a ecranului, pentru a naviga între secțiunile
                    de informații aferentă fiecăruia dintre ei. Meniul secundar este împărțit în:

                    <ol class="list-[lower-alpha]">
                        <li>Date personale - unde se află informațiile principale despre identitatea beneficiarului,
                            completate la momentul preluării beneficiarului în sistem. Aici se află și informațiile
                            legate de gospodăria, respectiv familia din care face parte, dacă este cazul. </li>
                        <li>Catagrafie - unde se află informațiile salvate în momentul realizării catagrafiei
                            beneficiarului și rezultatele sale în funcție de vulnerabilitățile identificate</li>
                        <li>Intervenții - unde se află toate serviciile și cazurile asociate acestui beneficiar, atât
                            cele planificate cât și cele realizate </li>
                        <li>Arhiva de documente - unde se află toate documentele încărcate în sistem cu referire la
                            acest beneficiar</li>
                        <li>Istoric modificări - unde sunt stocate toate modificările aduse profilului acestui
                            beneficiar de oricare dintre utilizatorii care au acces la acest profil.</li>
                    </ol>
                </li>

                <li>
                    <strong>Meniurile terțiare</strong>: aceste meniuri sunt utilizate pentru a te ajuta să navighezi în
                    secțiunile care conțin foarte multe date dispuse tabelar. Cel mai des utilizat meniu terțiar pe care
                    îl vei folosi este meniul terțiar din secțiunea Beneficiari. Acest meniu este divizat în patru
                    tab-uri distincte:

                    <ol class="list-[lower-alpha]">
                        <li>Toți beneficiarii: unde se află un tabel cu toți beneficiarii pe care i-ai introdus în
                            sistem sau care ți-au fost alocați </li>
                        <li>Beneficiari proprii: unde se află lista tuturor beneficiarilor tăi, monitorizați constant,
                            indiferent de statusul lor.</li>
                        <li>Beneficiari ocazionali: unde se află lista tuturor beneficiarilor ocazionali care nu sunt
                            monitorizați constant, indiferent de statusul lor.</li>
                        <li>Gospodării: unde se află lista tuturor gospodăriilor din care fac parte beneficiarii
                            înregistrați în aplicație. Această listă poate fi filtrată după Gospodărie sau după Familie
                        </li>
                    </ol>

                    <img
                        src="{{ Vite::asset('resources/images/help/image32.png') }}"
                        class="w-full"
                        alt=""
                    >
                </li>
            </ol>

            <p>Un alt meniu terțiar se află în secțiunea dedicată Activităților Comunitare unde cele trei taburi te
                ajută să navighezi între diferite categorii de activități:</p>

            <ol class="list-[lower-alpha]">
                <li>Campanii sănătate: unde vei vedea campaniile de sănătate trecute, în
                    derulare sau viitoare la care poți înscrie listele de beneficiari cu
                    care ai participat/vei participa.</li>

                <li>Activități de mediu: unde vei vedea activitățile trecute, în
                    derulare sau viitoare la care poți înscrie listele de beneficiari cu
                    care ai participat/vei participa.</li>

                <li>Activități administrative: unde poți marca în sistem activități
                    derulate în timpul programului sau în afara lui, care nu țin de
                    beneficiari, dar sunt direct conectate cu activitatea ta ca asistent
                    medical comunitar.</li>
            </ol>

            <img
                src="{{ Vite::asset('resources/images/help/image8.png') }}"
                alt=""
            >
        </section>

        <hr>

        <section id="breadcrumbs">
            <h2>Navigare prin marcaje (breadcrumbs)</h2>

            <p>Pentru a vă ajuta să navigați în secțiunile cu multiple tipuri de informații aveți la dispoziție și
                marcaje de navigație (denumite “breadcrumbs”) pe care le veți întâlni în diferite locuri în interiorul
                aplicației. Aceste marcaje sunt de tipul “Beneficiari/Numele beneficiarului/Catagrafie” sau
                “Beneficiar/Numele beneficiarului/Catagrafie/Formular de catagrafie” și au rolul de a vă spune care este
                traseul parcurs dintre secțiunea principală și pagina pe care vă aflați la interiorul aplicației. Aceste
                marcaje sunt interactive, astfel că dacă vă aflați de exemplu pe Formularul de catagrafie și faceți
                click pe marcajul “Numele beneficiarului” veți fi dus din nou la profilul beneficiarului sau dacă faceți
                click pe marcajul “Beneficiari” veți fi dus la pagina principală a secțiunii de Beneficiari.
            </p>

            <img
                src="{{ Vite::asset('resources/images/help/image29.png') }}"
                alt=""
                class="w-full"
            >
        </section>

        <hr>

        <section id="cautare-filtrare">
            <h2>Căutare și filtrare</h2>

            <p>Aplicația permite asistenților să caute informații în fiecare dintre secțiunile aplcației. Această
                căutare este contextualizată, ceea ce înseamnă că orice câmp de căutare este legat direct de informația
                prezentă în pagina în care te afli. De exemplu, dacă te afli în secțiunea Beneficiari pe tab-ul Toți
                beneficiarii și faci o căutare după numele “Ionescu” căutarea va returna toți beneficiarii tăi care au
                numele “Ionescu”. Dacă te afli în secțiunea Beneficiari pe tab-ul Beneficiari ocazionali și faci o
                căutare după numele “Ionescu”, cputarea va returna doar beneficiarii ocazionali care au numele
                “Ionescu”.
            </p>

            <img
                src="{{ Vite::asset('resources/images/help/image4.png') }}"
                class="w-full"
                alt=""
            >

            <p>Butonul din dreapta câmpului de căutare îți permite să personalizezi informațiile pe care le vezi despre
                beneficiari în tabel. Dacă apeși iconița cu trei coloane se va deschide un meniul dropdown în care sunt
                listate toate informațiile de bază despre beneficiari (de exemplu: Nume, Prenume, CNP, Localitate etc).
                Toate acestea au în dreptul lor un checkbox care poate fi selectat sau deselectat. Poți astfel selecta
                doar coloanele cu informații despre beneficiar pe care dorești să le vezi în tabel.
            </p>

            <p>Pentru a filtra informațiile din tabelele disponibile, poți utiliza opțiunea de filtrare. Faceți click în
                oricare secțiune sau tab unde aveți opțiune de filtrare disponibilă și se va extinde zona de căutare cu
                o serie de filtre după care poți restrânge o anumită căutare. Pe măsură ce setezi filtre acestea vor
                apărea dedesubt. Dacă vrei să renunți la un filtru este suficient să apeși pe marcajul “x” din dreptul
                fitrului pe care vrei să îl elimini.
            </p>

            <em>Exemplu:</em>
            <img
                src="{{ Vite::asset('resources/images/help/image34.png') }}"
                class="w-full mt-px"
                alt=""
            >
        </section>

        <hr>

        <section id="profilul-meu">
            <h2>Profilul meu</h2>

            <p>La crearea contului în sistem, vei primi un email cu un link de setare a parolei. Odată înrolat în
                sistem,
                vei putea să îți completezi și editezi profilul oricând vei avea nevoie. Profilul tău conține patru
                secțiuni
                principale:</p>

            <ol class="list-[upper-alpha]">
                <li>Informații generale - unde vei introduce date precum numărul de telefon, seria și numărul
                    acreditării, data emiterii acreditării etc.</li>
                <li>Studii și cursuri - unde vei introduce diferitele studii efectuate și cursuri de formare la care ai
                    participat în timp.</li>
                <li>Angajatori - unde vei avea lista tuturor structurilor angajatoare în cadrul cărora ai lucrat ca
                    asistent
                    medical comunitar.</li>
                <li>Arie acoperită - aria în care se află beneficiarii pe care îi deservești.</li>
            </ol>

            <img
                src="{{ Vite::asset('resources/images/help/image35.png') }}"
                class="w-full"
                alt=""
            >

            <p>Pentru a putea edita orice fel de informație din profilul tău de asistent medical comunitar, pe fiecare
                dintre tab-urile din profilul tău vei avea disponibil butonul “Editează”. </p>

            <ul>
                <li>Apasă pe “Editează”</li>
                <li>Modifică orice informație ai nevoie</li>
                <li>Apasă pe butonul “Salvare” când ai finalizat.</li>
            </ul>

            <p>Dacă nu ai operat nicio modificare, sau dacă te-ai răzgândit, atunci apasă pe butonul “Anulează”</p>
            <img
                alt=""
                src="{{ Vite::asset('resources/images/help/image12.png') }}"
                class="w-full"
            >

            <hr>

            <h3>Adăugare, editare și eliminare Studii și cursuri</h3>
            <p>Pentru a modifica secțiunea de “Studii și cursuri” este necesar să apeși butonul “Editează”. Odată ce te
                afli în modul de editare vei putea să: </p>

            <ul>
                <li>Modifici orice informație deja introdusă în secțiune direct în fiecare câmp</li>
                <li>Ștergi un curs sau un modul educațional în întregime cu ajutorul iconiței de coș din colțul din
                    dreapta sus al fiecărui modul</li>
                <li>Adaugi un nou curs sau modul educațional pe care l-ai urmat apăsând butonul “Adaugă studii” din
                    stânga jos. La apăsarea acestui butonul se va insera o nouă secțiune cu câmpuri necompletate pentru
                    a putea introduce informații despre curs/modul. La final, pentru a salva modificările apasă
                    “Salvare”. Dacă te-ai răzgândit sau dacă ai greșit, apasă “Anulare”. </li>
            </ul>

            <img
                alt=""
                src="{{ Vite::asset('resources/images/help/image15.png') }}"
                class="w-full"
            >

            <hr>

            <h3>Adăugare, editare și eliminare Angajatori</h3>
            <p>Pentru a modifica secțiunea de “Angajatori” este necesar să apeși butonul “Editează”. Odată ce te
                afli în modul de editare vei putea să: </p>

            <ul>
                <li>Modifici orice informație deja introdusă în secțiune direct în fiecare câmp</li>
                <li>Ștergi un Angajtor în întregime cu ajutorul iconiței de coș din colțul din dreapta sus al fiecărui
                    modul</li>
                <li>Adaugi un nou Angajator apăsând butonul “Adaugă angajator” din stânga jos. La apăsarea acestui
                    butonul se va insera o nouă secțiune cu câmpuri necompletate pentru a putea introduce informații
                    despre Angajator. La final, pentru a salva modificările apasă “Salvare”. Dacă te-ai răzgândit sau
                    dacă ai greșit, apasă “Anulare”. </li>
            </ul>

            <img
                alt=""
                src="{{ Vite::asset('resources/images/help/image7.png') }}"
                class="w-full"
            >
            <hr>

            <h3>Adăugare, editare și eliminare Arii acoperite</h3>
            <p>Pentru a modifica secțiunea de “Arii acoperite” este necesar să apeși butonul “Editează”. Odată ce te
                afli în modul de editare vei putea să: </p>

            <ul>
                <li>Modifici orice informație deja introdusă în secțiune direct în fiecare câmp</li>
                <li>Ștergi o arie în întregime cu ajutorul iconiței de coș din colțul din dreapta sus al fiecărui
                    modul</li>
                <li>Adaugi o nouă arie apăsând butonul “Adaugă angajator” din stânga jos. La apăsarea acestui butonul se
                    va insera o nouă secțiune cu câmpuri necompletate pentru a putea introduce informații despre aria
                    acoperită. La final, pentru a salva modificările apasă “Salvare”. Dacă te-ai răzgândit sau dacă ai
                    greșit, apasă “Anulare”. </li>
            </ul>

            <img
                alt=""
                src="{{ Vite::asset('resources/images/help/image7.png') }}"
                class="w-full"
            >

            <p>Toate informațiile din profilul tău de asistent medical comunitar sunt vizibile și pentru celelalte
                tipuri de utilizatori cât timp au o relație de lucru directă cu tine (angajatorul/anagajtorii tăi,
                Ministerul Sănătății, Super Admin). Ceilalți asistenți medicali comunitari, adică utilizatorii cu cont
                identic cu al tău nu pot să vadă datele tale personale din profil, la fel cum nici angajatorii
                celorlalți asistenți nu pot vedea aceste informații.</p>
        </section>

        <hr>

        <section id="beneficiari">
            <h2>Beneficiari</h2>

            <p>Secțiunea dedicată beneficiarilor este parte integrantă din meniul principal:</p>
            <ul>
                <li>Faceți click pe butonul Beneficiari din meniul principal</li>
                <li>Vi se va afișa lista de beneficiari cu o serie de tab-uri (navigare terțiară) pentru a vă ajuta în
                    navigare.</li>
                <li>Aceste filtre sunt afișate ca patru tabele individuale: Toți beneficiarii; Beneficiari proprii;
                    Beneficiari ocazionali; Gospodării;</li>
                <li>Faceți click pe oricare dintre beneficiarii din listă pentru a accesa toate informațiile legate de
                    un beneficiar </li>
                <li>Odată ce ați deschis profilul unui beneficiar, în partea stângă a ferestrei veți avea la dispoziție
                    un meniu secundar organizat în cinci secțiuni: Date personale; Catagrafie; Intervenții; Arhivă
                    documente; Istoric modificări;</li>
                <li>Pentru a adăuga un beneficiar nou, faceți click pe butonul <strong>Adaugă beneficiar</strong></li>
            </ul>

            <h3>Statusurile unui beneficiar</h3>
            <p>Fiecare beneficiar poate avea unul dintre următoarele cinci statusuri:</p>

            <ul>
                <li><strong>BENEFICIAR ÎNREGISTRAT</strong> - marcat cu culoarea portocalie în aplicație. Acesta este
                    statusul inițial al oricărui beneficiar, odată ce i s-au introdus datele obligatorii de baza pentru
                    a fi identificat, dar înainte de a fi catagrafiat pentru prima dată. Acest status se alocă automat
                    de către sistem. </li>
                <li><strong>BENEFICIAR CATAGRAFIAT</strong> - marcat cu culoarea albastru în aplicație. Acest status
                    indică faptul că beneficiarului înregistrat în aplicație i s-a făcut prima catagrafie, dar încă nu a
                    fost creată nicio intervenție și nu i s-a oferit încă niciun serviciu de către asistentul medical
                    comunitar. Acest status se alocă automat după completarea catagrafiei dar poate fi schimbat manual
                    dacă este cazul.</li>
                <li><strong>BENEFICIAR ACTIV</strong> - marcat cu culoarea verde în aplicație. Acest status indică
                    faptul că beneficiarul a fost înregistrat, catagrafiat și are intervenții active în aplicație. Acest
                    status se alocă automat odată cu deschiderea primei intervenții pentru beneficiar în sistem, dar
                    poate fi schimbat manual dacă este cazul. </li>
                <li><strong>BENEFICIAR INACTIV</strong> - marcat cu culoarea gri în aplicație. Acest status este alocat
                    manual și marchează faptul că acest beneficiar nu primește servicii în mod regulat, dar care din
                    timp în timp este monitorizat de un asistent medical comunitar. </li>
                <li><strong>SCOS DIN EVIDENȚĂ</strong> - marcat cu culoarea roșie în aplicație. Acest status indică
                    faptul că respectivul beneficiar nu va mai primi servicii de niciun fel. Pentru a schimba statusul
                    unui beneficiar în INACTIV va fi necesară o justificare, informație care se va introduce în
                    aplicație la schimbarea statusului și stocată în profilul beneficiarului. Exemple de justificare
                    pentru inactivarea unui beneficiar: relocare geografică, ineligibilitate pentru a primii servicii,
                    instituționalizare, deces etc. </li>
            </ul>

            <h3>A. Listele de beneficiari</h3>
            <p>Listele de beneficiari sunt prezentate sub patru secțiuni distincte prin care puteți naviga făcând click
                pe fiecare dintre ele. Cele patru liste sunt: Toți beneficiarii; Beneficiari proprii; Beneficiari
                ocazionali; Gospodării;</p>

            <p><strong>Toți beneficiarii</strong>: aceasta este lista tuturor beneficiarilor din sistem care vă sunt
                alocați sau pe care i-ați luat în evidență, indiferent de statusul lor. Ace’tia sunt afișați în tabel în
                ordine invers cronologică cu cel mai recent beneficiar adăugat în sistem primul din listă. Acest tabel
                conține următoarele coloane:</p>
            <ul>
                <li>ID-ul beneficiarului</li>
                <li>Numele de familie al beneficiarului</li>
                <li>Prenumele beneficiarului</li>
                <li>CNP (Codul Numeric Personal)</li>
                <li>Vârsta </li>
                <li>Localitate</li>
                <li>Tip beneficiar</li>
                <li>Status </li>
                <li>Buton de vizualizare (simbolul ochi) care vă duce la profilul acelui beneficiar.</li>
            </ul>

            <p><strong>Beneficiari proprii</strong> aceasta este lista tuturor beneficiarilor proprii care sunt
                monitorizați constant, indiferent de statusul lor. Acest tabel conține următoarele coloane:</p>

            <ul>
                <li>ID-ul beneficiarului</li>
                <li>Numele de familie al beneficiarului</li>
                <li>Prenumele beneficiarului</li>
                <li>CNP (Codul Numeric Personal)</li>
                <li>Vârsta </li>
                <li>Localitate</li>
                <li>Status </li>
                <li>Buton de vizualizare (simbolul ochi) care vă duce la profilul acelui beneficiar.</li>
            </ul>

            <p><strong>Gospodării</strong> aceasta este lista tuturor gospodăriilor din care fac parte beneficiarii
                înregistrați în aplicație. Această listă poate fi filtrată după Gospodărie sau după Familie.
            </p>

            <p>O Gospodărie este un grup de unul sau mai mulți beneficiari constituită după criteriul locuirii la comun
                (la aceeași adresă). O Gospodărie poate fi formată din una sau mai multe familii. O Familie este
                reprezentată de membri înrudiți care locuiesc sau nu în aceeași gospodărie. Gospodăriile, respectiv
                Familiile sunt create de către asistentul medical comunitar în aplicație pe baza propriilor evaluări.
                Pentru a vedea toți beneficiarii dintr-o gospodărie sau familie faceți click pe săgeata din dreptul
                numelui Gospodăriei din tabel. </p>

            <img
                alt=""
                src="{{ Vite::asset('resources/images/help/image24.png') }}"
                class="w-full"
            >

            <h4>Pentru a crea o Gospodărie/Familie:</h4>
            <ul>
                <li>Apăsați butonul “Adaugă gospodărie”.</li>
                <li>Completați numele gospodăriei.</li>
                <li>Adaugați o familie sau membri în gospodărie căutându-i direct printre beneficiari cu ajutorul
                    funcției de căutare.</li>
                <li>Aceste informații pot fi ulterior editate și din profilul fiecărui beneficiar care face parte din
                    acea gospodărie. </li>
            </ul>

            <img
                alt=""
                src="{{ Vite::asset('resources/images/help/image23.png') }}"
                class="w-full"
            >

            <h4>Pentru a adăuga un beneficiar într-o Gospodărie/Familie deja existentă: </h4>
            <ul>
                <li>Selectați gospodăria sau familia.</li>
                <li>Faceți click pe “Adaugă membru”</li>
            </ul>

            <hr>

            <h3>Adăugarea unui beneficiar</h3>
            <p>Pentru a adăuga un beneficiar în sistem mergeți în secțiunea “Beneficiari” din meniul principal și
                apăsați pe butonul din dreapta sus “Adaugă beneficiar”. </p>
            <img
                alt=""
                src="{{ Vite::asset('resources/images/help/image6.png') }}"
                class="w-full"
            >

            <p>Primul pas din adăugarea unui beneficiar în sistem este completarea unor informații de bază despre
                acesta: </p>

            <ul>
                <li>Selectează din primul dropdown dacă este un beneficiar propriu sau un beneficiar ocazional </li>
                <li>Introdu datele solicitate în formularul din pagină: Prenume, Nume, CNP (decă există), tipul de act
                    de identitate, dacă există (dacă nu, vei putea alege opțiunea “Nu are act de identitate”), seria
                    actului, dacă există, data nașterii, genul, etnia și dacă este sau nu încadrat în muncă. Următoarea
                    secțiune va solicita informații despre gospodărie și familie, județ, localitate, adresa, numărul de
                    telefon dacă există, și apoi vei putea adăuga observații sau comentarii dacă este necesar. </li>
                <li>Pentru a finaliza procesul apasă pe “Creare”. Dacă vrei să anulezi procesul, apasă pe “Anulare”
                </li>
            </ul>

            <img
                alt=""
                src="{{ Vite::asset('resources/images/help/image28.png') }}"
                class="w-full"
            >

            <p>Odată ce a fost creat, beneficiarul primește statusul de “Beneficiar înregistrat” și i se generează
                automat un profil.</p>

            <hr>
            <h3>Profilul unui Beneficiar</h3>

            <p>Informația despre un beneficiar și toată activitatea ta în raport cu un beneficiar se gestionează din
                profilul acestuia. În pagina “Overview” din meniu se află sumarul informațiilor despre beneficiar. Un
                beneficiar nou înregistrat nu va avea nimic afișat în partea dreaptă a ecranului în secțiunea
                “Intervenții active” până nu va fi deschisă o intervenție pentru acesta.</p>

            <img
                alt=""
                src="{{ Vite::asset('resources/images/help/image5.png') }}"
                class="w-full"
            >

            <p><strong>Secțiunea “Date personale”</strong> conține informațiile de identificare ale beneficiarului
                precum și date de
                tipul din ce gospodărie face parte, dacă este cazul, din ce familie face parte daca este cazul și date
                de contact. Pentru a edita această secțiune apasă butonul “Editează” din dreapta sus. </p>

            <p><strong>Secțiunea “Catagrafie”</strong> conține catagrafia beneficiarului. Dacă este un beneficiar nou,
                această secțiune
                nu va afișa informații. Dacă beneficiarul a fost catagrafiat cel puțin o dată aici vor fi afișate
                vulnerabilitățile identificate prin catagrafie. Pentru a catagrafia un beneficiar apasă butonul
                “Catagrafiază beneficiar” sau selectează această opțiune apăsând “Acțiuni rapide” din dreapta sus și
                selectând opțiunea “Actualizează catagrafie”. </p>

            <img
                alt=""
                src="{{ Vite::asset('resources/images/help/image27.png') }}"
                class="w-full"
            >

            <p>Catagrafierea unui beneficiar prespune aplicarea unui chestionar exhaustiv organizat în cinci secțiuni.
            </p>

            <ul>
                <li>Informații generale</li>
                <li>Vulnerabilități socio-economice</li>
                <li>Vulnerabilități de sănătate</li>
                <li>Sănătate reproductivă</li>
                <li>Observații</li>
            </ul>

            <img
                alt=""
                src="{{ Vite::asset('resources/images/help/image33.png') }}"
                class="w-full"
            >
            <img
                alt=""
                src="{{ Vite::asset('resources/images/help/image18.png') }}"
                class="w-full"
            >
            <img
                alt=""
                src="{{ Vite::asset('resources/images/help/image13.png') }}"
                class="w-full"
            >

            <p>Pentru a realiza o catagrafie este necesară completarea tuturor câmpurilor din această pagină. Unele
                dintre câmpuri, în funcție de selecția făcută vor declanșa afișarea unor câmpuri suplimentare. De
                exemplu: secțiunea “Vulnerabilități de sănătate” prevede completarea unor informații suplimentare în
                cazul în care beneficiarul are dizabilități. Odată selectat că un beneficiar are o dizabilitate, cu sau
                fără certificat se va deschide o secțiune de detalii unde vi se vor solicita informații în plus, cum ar
                fi: tipul dizabilității, gradul de dizabilitate, diagnosticul, data de debut etc.</p>

            <img
                alt=""
                src="{{ Vite::asset('resources/images/help/image21.png') }}"
                class="w-full"
            >

            <p>Odată finalizată catagrafia în profilul beneficiarului statusul acestuia se va schimba din “Înregistrat”
                în “Catagrafiat” și va fi marcat corespunzător în baza de date. În secțiunea “Catagrafie” din meniul
                secundar al acestui beneficiar vei vedea sumarul vunerabilităților identificate automat de sistem, pe
                baza selecțiilor făcute de tine în timpul catagrafierii.</p>

            <ul>
                <li>La finalul sumarului vei putea vedea care a fost data la care a fost realizată catagrafia </li>
                <li>Pentru a vedea din nou formularul detaliat apasă butonul “Vezi formular”</li>
                <li>Pentru a actualiza catagrafia unui beneficiar, apasă pe “Acțiuni rapide” și selectează “Actualizează
                    catagrafie”. </li>
                <li>Pentru a vedea istoricul modificărilor catagrafiei apasă pe linkul “Vezi istoric modificări” din
                    dreapta jos.</li>
            </ul>

            <img
                alt=""
                src="{{ Vite::asset('resources/images/help/image17.png') }}"
                class="w-full"
            >

            <p><strong>Secțiunea “Intervenții”</strong> conține lista tuturor intervențiilor asupra unui beneficiar.
                Intervențiile se referă atât la servicii individuale oferite unui beneficiar cât și la un grup de
                servicii grupate în interiorul unui caz. Toate intervențiile sunt asociate uneia sau mai multor
                vulnerabilități pe care le adresează. În general, un caz care grupează o serie de mai multe servicii
                adresează o vulnerabilitate mai complexă sau o combinație de vulnerabilități (exemplu: monitorizarea
                unei sarcini, monitorizarea unui beneficiar epileptic etc). </p>
            <p> Pentru a adăuga un serviciu sau pentru a deschide un caz, din secțiunea “Intervenții” apasă pe unul
                dintre cele doup butoane dedicate din dreapta sus: “Adaugă serviciu” sau “Deschide caz”. </p>

            <img
                alt=""
                src="{{ Vite::asset('resources/images/help/image19.png') }}"
                class="w-full"
            >

            <p>După ce apeși pe “Adaugă serviciu” se va deschide o fereastră de tip pop-up în care ți se vor solicita
                detalii despre serviciul pe care vrei să îl oferi acestui beneficiar. Vei selecta informații precum
                numele serviciului (dintr-o listă predefinită), ce vulnerabilitate adresează serviciul respectiv, dacă
                este un serviciul planificat a fi oferit mai târziu sau dacă a fost deja prestat, data la care va fi
                efectuat sau la care a fost deja oferit, bifă pentru a marca faptul că serviciul este parte din
                abordarea integrată, un câmp dedicat de observații cu privire la serviciu și o bifă care să marcheze
                dacă acest serviciu a fost prestat în afara orelor de lucru. </p>

            <p>Pentru a adăuga acest serviciu apasă “Adaugă”. Dacă vrei să renunți, apasă “Anulează”.</p>

            <img
                alt=""
                src="{{ Vite::asset('resources/images/help/image30.png') }}"
                class="w-full"
            >

            <p>După ce apeși pe “Deschide caz” se va deschide o fereastră de tip pop-up în care ți se vor solicita
                detalii suplimentare cum ar fi denumirea cazului, dacă a fost deschis la inițiativa proprie sau dacă a
                fost deschis la inițiativa unui alt utilizator de tipul medicului de familie, DSP sau echipa comunitară
                etc, ce vulnerabilitate adresează etc. </p>

            <img
                alt=""
                src="{{ Vite::asset('resources/images/help/image25.png') }}"
                class="w-full"
            >

            <p>Odată deschis un caz vei putea adăuga servicii în interiorul cazului. După crearea cazului:</p>
            <ul>
                <li>Selectează cazul din tabel și apoi apasă pe “Vezi fișă”</li>
                <li>Apasă pe butonul “Adaugă serviciu” din al doilea tabel și urmează pașii indicați</li>
                <li>Dacă vrei să închizi un caz, apasă pe butonul “Închide intervenție”</li>
                <li>Se va afișa un mesaj care va solicita confirmarea închiderii intervenției. Poți oricând să
                    redeschizi o</li>
                <li>intervenție pe care ai închis-o anterior</li>
            </ul>

            <img
                alt=""
                src="{{ Vite::asset('resources/images/help/image11.png') }}"
                class="w-full"
            >

            <p>Odată ce ai adăugat toate serviciile realizate sau planificate în interiorul unui caz, în secțiunea
                “Intervenții” vei putea vedea un sumar al cazului, grupat sub vulnerabilitatea adresată. </p>
            <ul>
                <li>Coloana “Servicii realizate” indică numărul de servicii oferite din totalul de servicii
                    planificatefie individuale, fie în interiorul unui caz</li>
                <li>Toate serviciile (individuale sau grupate în cadrul unor cazuri) vor fi prezentate în tabel grupate
                    pe vulnerabilitățile pe care le adresează</li>
            </ul>

            <em>Exemplu:</em>
            <img
                alt=""
                src="{{ Vite::asset('resources/images/help/image9.png') }}"
                class="w-full"
            >

            <p><strong>Secțiunea “Arhiva de documente”</strong> conține lista documentelor încărcate în sistem în
                relație cu un beneficiar. Documentele sunt listate tabelar, în ordine invers cronologică și pot fi
                vizualizate sau descărcate din sistem, dacă este cazul. Pentru a vizualiza un document apăsați iconița
                cu simbolul “ochi” din dreptul documentului.
            </p>

            <img
                alt=""
                src="{{ Vite::asset('resources/images/help/image10.png') }}"
                class="w-full"
            >

            <p><strong>Secțiunea “Istoric modificări”</strong> conține lista tuturor modificărilro aduse profilului
                beneficiarului de către orice user care are acces la acesta, precum și modificările automate pe care le
                aduce sistemul asupra unui beneficiar. </p>
        </section>

        <hr>

        <section id="programari">
            <h2>Programări</h2>

            <p>Pentru a veni în sprijinul tău, secțiunea “Programări” din meniul principal va lista toate serviciile
                planificate, organizate în cadrul unor vizite. O programare, adică o vizită, poate să grupeze mai multe
                servicii oferite în aceeași zi de exemplu. Pentru a adăuga o programare apasă butonul “Adaugă
                programare” și completează câmpurile solicitate.</p>

            <img
                alt=""
                src="{{ Vite::asset('resources/images/help/image22.png') }}"
                class="w-full"
            >
        </section>

        <hr>

        <section id="activitati-comunitare">
            <h2>Activități comunitare</h2>

            <p>Activitățile comunitare sunt acțiuni de sănătate publică sau de mediu sau activități administrative pe
                care le poți derula pentru beneficiari sau împreună cu aceștia. Activitățile pot fi adăugate de orice
                tip de utilizator în sistem. Pentru a adăuga o activitate apasă butonul “Acțiuni rapide” din colțul din
                dreapta sus și selectează tipul de activitate pe care vrei să îl introduci. Se va deschide o fereastră
                de tip pop-up în care vei putea denumi activitatea, numele organizatorului dacă este o activitate de
                mediu sau de sănătate, locul, vei putea încărca lista de participanți dacă este cazul (dacă activitatea
                deja a avut loc de exemplu) și vei putea completa informații suplimentare. Pentru a salva activitatea
                apasă butonul “Adaugă”, pentru a renunța apasă butonul “Anulează”</p>
            <img
                alt=""
                src="{{ Vite::asset('resources/images/help/image1.png') }}"
                class="w-full"
            >
        </section>

        <hr>

        <section id="rapoarte">
            <h2>Rapoarte</h2>

            <p>Secțiunea de “Rapoarte” poate fi accesată din meniul principal și este organizată în două tab-uri (meniu
                terțiar): Generator rapoarte și Rapoarte salvate. Sistemul permite generarea dinamică de rapoarte pe
                baza unor selecții pe care le poți face cu ajutorul generatorului integrat. Odată ce ai configurat un
                anumit raport, acesta poate fi salvat și va fi afișat în tab-ul de “Rapoarte salvate”</p>
            <img
                alt=""
                src="{{ Vite::asset('resources/images/help/image26.png') }}"
                class="w-full"
            >

            <p>“Generator rapoarte” - în această secțiune vei putea selecta tipul de raport pe care vrei să îl generezi,
                intervalul de timp pentru care vrei să generezi aceste rapoarte, vei putea selecta categoria de vârstă,
                genul și alte valori predefinite. În funcție de tipul de raport selectat, în secțiunea de Indicatori vei
                putea selecta toți indicatorii pe care vrei să îi raportezi. Câmpurile dedicate selecției de interval de
                timp sunt obligatorii. Dacă nu selectezi niciun indicator, tabelul afișat va fi gol. De fiecare dată
                când generezi un raport este necesar să selectezi cel puțin un indicator de raportare. Informațiile se
                vor afișa tabelar</p>

            <img
                alt=""
                src="{{ Vite::asset('resources/images/help/image31.png') }}"
                class="w-full"
            >

            <p>În secțiunea “Rapoarte salvate” vei putea vedea rapoarte create anterior care au fost salvate în sistem
                pentru a avea acces cât mai facil la ele, fără a fi nevoie să operezi de fiecare dată aceleași selecții
                manual. </p>

            <img
                alt=""
                src="{{ Vite::asset('resources/images/help/image37.png') }}"
                class="w-full"
            >
        </section>

    </div>
</x-filament::page>
