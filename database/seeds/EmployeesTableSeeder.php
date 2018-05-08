<?php

use Illuminate\Database\Seeder;
use App\Employee;
use Carbon\Carbon;
use App\ContactCenter;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employees = [
            ['John', 'Doe', 1983, 0, '2010-10-01', '2011-01-23', 'Municipality Contact Center'],
            ['Jane', 'Doe', 1989, 1, '2018-01-01', null, 'Department of Motor Vehicles'],
            ['William', 'McMaster', 1971, 0, '2010-10-01', '2012-04-16', 'Municipality Contact Center'],
            ['Virginia', 'Cobalt', 1995, 1, '2015-07-06', null, 'Municipality Contact Center'],
            ['Mark', 'Cuban', 1976, 0, '2014-04-01', null, 'Engineering Department'],
            ['Marsha', 'Rodriguez', 1989, 1, '2016-01-31', null, 'Engineering Department'],
            ['Donald', 'The Duck', 1971, 0, '2017-10-09', '2018-01-16', 'Department of Motor Vehicles'],
            ['Paris', 'Ritz', 1995, 1, '2018-03-01', null, 'Water and Sewage'],
        ];
        $count = count($employees);

        # Loop through each employee, adding them to the database
        foreach ($employees as $key => $employeeData) {
            $ccName = $employeeData[6];

            # Find the contact center
            $cc_id = ContactCenter::where('name', '=', $ccName)->pluck('id')->first();

            $employee = new Employee();

            $employee->created_at = Carbon::now()->subDays($count)->toDateTimeString();
            $employee->updated_at = Carbon::now()->subDays($count)->toDateTimeString();
            $employee->first_name = $employeeData[0];
            $employee->last_name = $employeeData[1];
            $employee->birth_year = $employeeData[2];
            $employee->gender = $employeeData[3];
            $employee->employment_date = $employeeData[4];
            $employee->termination_date = $employeeData[5] ? $employeeData[5] : NULL;
            $employee->contact_center_id = $cc_id;

            $employee->save();
            $count--;
        }
    }
}