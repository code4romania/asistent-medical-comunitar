<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SirutaCitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    const COUNTY_TYPE = 1;
    const NAME = 1;
    const COUNTY_ID = 9;
    const   TYPE = 6;

    public function run()
    {
        $file = fopen('database/seeders/data/siruta2.csv', 'r');
        while (($data = fgetcsv($file, 1000, ";")) !== false) {
            if (!in_array($data[self::TYPE], [1, 2])) {
                $tmpArray[] = [
                    'name' => $data[self::NAME],
                    'county_id' => $data[self::COUNTY_ID],
                ];
            }
        }
        unset($tmpArray[0]);
        fclose($file);
        City::insert($tmpArray);

//        $batches = array_chunk($tmpArray, 1000);
//        foreach ($batches as $batch) {
//            City::insert($batch);
//        }
    }
}
