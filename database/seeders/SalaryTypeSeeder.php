<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SalaryType;


class SalaryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$data = ['Hourly', 'Fixed', 'Scenerio Based'];

    	foreach ($data as $key => $value) {
    		$existRecord = SalaryType::whereType($value)->first();
    		if (!$existRecord) {
    			SalaryType::create(['type' => $value]);
    		}
    	}

    }
}
