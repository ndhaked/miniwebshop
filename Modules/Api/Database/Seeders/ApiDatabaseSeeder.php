<?php

namespace Modules\Api\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ApiDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ImportCustomerMasterDataSeederTableSeeder::class);
        $this->call(ImportProductsMasterDataSeederTableSeeder::class);
    }
}
