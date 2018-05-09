<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ContactCentersTableSeeder::class);
        $this->call(EmployeesTableSeeder::class);
        $this->call(ServicesTableSeeder::class);
        $this->call(ContactCenterServiceSeeder::class);
    }
}
