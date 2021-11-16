<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SalaryType;
use App\Models\Department;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
	        $this->call([
	        	SalaryTypeSeeder::class,
	        	DepartmentSeeder::class,
	    ]);
    }
}
