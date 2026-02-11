<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Report;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Symfony\Component\Console\Helper\ProgressBar;

class FixReportsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reports:fix
                            {--chunk=1000 : Rows per processing chunk}
                            {--dry-run : Do not perform updates}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Re-generate UUIDs for all reports that have a UUIDv4. Update indicators from list to map with labels.';

    /**
     * [['oldId' => ..., 'newId' => ...], ...].
     *
     * @var array
     */
    protected array $buffer = [];

    protected int $total = 0;

    protected ProgressBar $progressBar;

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $reports = Report::query()
            ->select(['id', 'indicators', 'created_at']);

        $this->progressBar = $this->output->createProgressBar($reports->count());
        $this->progressBar->start();

        $reports
            ->lazy((int) $this->option('chunk'))
            ->each(function (Report $report): void {
                if (Str::isUuid($report->id, 4)) {
                    $report->id = Str::uuid7($report->created_at)->toString();
                }

                if (Arr::isList($report->indicators->all())) {
                    $report->indicators = $report->indicators
                        ->mapWithKeys(fn (string $indicator) => [
                            $indicator => $this->getIndicatorLabel($indicator),
                        ]);
                }

                if (! $this->option('dry-run')) {
                    Report::withoutTimestamps(fn (): bool => $report->save());
                }

                $this->progressBar->advance();
            });

        return self::SUCCESS;
    }

    protected function getIndicatorLabel(string $indicator): string
    {
        return match ($indicator) {
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
            //
            'P01' => 'Gravidă cu probleme sociale',
            'P02' => 'Gravidă cu probleme medicale (sarcină cu risc)',
            'P03' => 'Gravidă care a efectuat consultații prenatale',
            'P04' => 'Avort spontan',
            'P05' => 'Avort medical',
            'P06' => 'Naştere înregistrată la domiciliu',
            'P07' => 'Gravidă minoră',
            'P08' => 'Gravidă neînscrisă la medicul de familie',
            'P09' => 'Gravidă înscrisă de asistentul medical comunitar/moaşă la medicul de familie',
            'P10' => 'Gravidă consiliată',
            'P11' => 'Diagnosticare precoce a sarcinii',
            'P12' => 'Îngrijiri prescrise de medic',
            //
            'C01' => 'Nou-născut (0-27 de zile)',
            'C02' => 'Prematur',
            'C03' => 'Copil alimentat exclusiv la sân',
            'C04' => 'Caz de boală infecțioasă',
            'C05' => 'Copil cu boală cronică',
            'C06' => 'Caz profilaxie rahitism (vit. D) și anemie (fier)',
            'C07' => 'Copil nevaccinat conform calendarului',
            'C08' => 'Caz HIV/SIDA',
            'C09' => 'Caz TBC în tratament',
            'C10' => 'Caz copil cu nevoi medicale speciale',
            'C11' => 'Caz copil cu nevoi medicale speciale - fără certificat de handicap',
            'C12' => 'Caz copil abandonat',
            'C13' => 'Caz copil dezinstituționalizat',
            'C14' => 'Caz social',
            'C15' => 'Caz copil părăsit',
            'C16' => 'Copil abuzat',
            'C17' => 'Deces la domiciliu',
            'C18' => 'Deces la spital',
            'C19' => 'Copil cu părinți migranți',
            'C20' => 'Vaccinat conform calendarului',
            'C21' => 'Anunțat la vaccinare',
            'C22' => 'Copil contact TBC',
            'C23' => 'Copil din familie monoparentală',
            'C24' => 'Copil cu dizabilități',
            'C25' => 'Copil cu tulburări mintale şi de comportament',
            'C26' => 'Copil consumator de substanțe psihotrope',
            'C27' => 'Copil 0-18 ani (fără probleme medicosociale)',
            'C28' => 'Caz tratament paliativ (fază terminală)',
            'C29' => 'Copil neînscris la medicul de familie',
            'C30' => 'Copil înscris la medicul de familie',
            'C31' => 'Triaj epidemiologic',
            //
            'RD01' => 'AC-trisomie 21 (sindrom Down)',
            'RD02' => 'AC-trisomie 13 (sindrom Patau)',
            'RD03' => 'AC-trisomie 18 (sindrom Edwards)',
            'RD04' => 'AC-anomalii ale cromozomului X',
            'RD05' => 'AC-anomalii ale cromozomului Y',
            'RD06' => 'AC-sindrom Lejeune (cri du chat)',
            'RD07' => 'AC-sindrom Wolf Hirschhorn',
            'RD08' => 'AC-sindrom Prader Willi',
            'RD09' => 'AC-sindrom Angelman',
            'RD10' => 'AC-sindrom Williams',
            'RD11' => 'AC-sindrom Rubinstein Taybi',
            'RD12' => 'AC-sindrom DiGeorge-velocardiofacial',
            'RD13' => 'AC-retinoblastom',
            'RD14' => 'AC-nefroblastom',
            'RD15' => 'AC-sindrom Beckwith Wiedemann',
            'RD16' => 'AC-alte anomalii cromozomiale',
            'RD17' => 'G-osteogeneză imperfectă',
            'RD18' => 'G-boala Fabry',
            'RD19' => 'G-boala Pompe',
            'RD20' => 'G-boala Gaucher',
            'RD21' => 'G-tirozinemie',
            'RD22' => 'G-mucopolizaharidoză tip II (sindromul Hunter)',
            'RD23' => 'G-mucopolizaharidoză tip I (sindromul Hurler)',
            'RD24' => 'G-afibrinogenemie congenitală',
            'RD25' => 'G-sindrom de imunodeficienţă primară',
            'RD26' => 'G-epidermoliză buloasă',
            'RD27' => 'G-fenilcetonurie sau deficit de tetrahidrobiopterină (BH4)',
            'RD28' => 'G-scleroză tuberoasă',
            'RD29' => 'G-scleroză laterală amiotrofică',
            'RD30' => 'G-mucoviscidoză',
            'RD31' => 'G-distrofie musculară Duchennesi Becker',
            'RD32' => 'G-angioedem ereditar',
            'RD33' => 'G-neuropatie optică ereditară Leber',
            'RD34' => 'G-thalassemia',
            'RD35' => 'G-boala Wilson',
            'RD36' => 'G-sindrom Marfan',
            'RD37' => 'G-hemofilie',
            'RD38' => 'G-sindrom Niemann Pick',
            'RD39' => 'G-sindrom Rett',
            'RD40' => 'G-sindrom Noonan-rasopatie',
            'RD41' => 'G-neurofibromatoză',
            'RD42' => 'G-boala Huntington',
            'RD43' => 'G-alte boli genetice',
        };
    }
}
