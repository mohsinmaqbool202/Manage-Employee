<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$data = ['Tax', 'Accounting'];

    	foreach ($data as $key => $value) {
    		$existRecord = Department::whereName($value)->first();
    		if (! $existRecord) {
    			Department::create(['name' => $value]);
    		}
    	}

       	// DB::table('departments')->insert([
        //     'name' => 'Tax',
        // ]);
        // DB::table('departments')->insert([
        //     'name' => 'Accounting',
        // ]); 
    }
}
