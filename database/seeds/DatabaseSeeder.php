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
        $this->call(TouchpointsTableSeeder::class);
        $this->call(ContactCenterTouchpointSeeder::class);
        $this->call(PillarsTableSeeder::class);
        $this->call(PerspectivesTableSeeder::class);
        $this->call(FocusAreasTableSeeder::class);
        $this->call(StandardsTableSeeder::class);
    }
}
