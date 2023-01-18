<?php

namespace Database\Seeders;

use App\Models\County;
use Clockwork\Request\Log;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SirutaCountiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    const   FSJ = 2;
    const  NAME = 1;
    const ALIAS = 3;

    public function run()
    {
//        echo "Start counties insert\n";
        $tmpArray = [];
        $file = fopen('database/seeders/data/siruta-judete.csv', 'r');
        while (($data = fgetcsv($file, 1000, ";")) !== false) {
            $tmpArray[] = [
                'id' => $data[self::FSJ],
                'name' => $data[self::NAME],
                'alias' => $data[self::ALIAS],
            ];
        }
        unset($tmpArray[0]);
        fclose($file);
        County::insert($tmpArray);
//        echo " End counties insert, total insert: " . count($tmpArray) . "\n";
    }
}
