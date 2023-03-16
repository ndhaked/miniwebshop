<?php

namespace Modules\Api\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Api\Entities\Products;
use Illuminate\Support\Facades\Log;

class ImportProductsMasterDataSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Products::truncate();
        $csvData = fopen(base_path('database/csv/products.csv'), 'r');
        $transRow = true;
        $imported = 0;
        $notimported = 0;
        while (($data = fgetcsv($csvData, 555, ',')) !== false) {
            if (!$transRow) {
                if(Products::create([
                    'productname' => $data['1'],
                    'price' => $data['2'],
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
