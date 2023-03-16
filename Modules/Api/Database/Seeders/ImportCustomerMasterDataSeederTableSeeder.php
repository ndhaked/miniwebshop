<?php

namespace Modules\Api\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Api\Entities\Customers;
use Illuminate\Support\Facades\Log;

class ImportCustomerMasterDataSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customers::truncate();
        $csvData = fopen(base_path('database/csv/customers.csv'), 'r');
        $transRow = true;
        $imported = 0;
        $notimported = 0;
        while (($data = fgetcsv($csvData, 555, ',')) !== false) {
            if (!$transRow) {
                if(Customers::create([
                    'job_title' => $data['1'],
                    'email' => $data['2'],
                    'first_last_name' => $data['3'],
                    'registered_since' => \Carbon\Carbon::parse($data['4']),
                    'phone' => $data['5'],
                ])){
                    $imported++;
                }else{
                    $notimported++;
                }
            }
            $transRow = false;
        }
        Log::info('Customers Import Logs => ', ['imported' => $imported,'notimported' => $notimported]);
        fclose($csvData);
    }
}
