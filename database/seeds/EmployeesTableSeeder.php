<?php

use Illuminate\Database\Seeder;
use App\Employee;
use Carbon\Carbon;

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
            ['John', 'Doe', 1983, 0, '2010-10-01', '2011-01-23'],
            ['Jane', 'Doe', 1989, 1, '2018-01-01', null],
            ['William', 'McMaster', 1971, 0, '2010-10-01', '2012-04-16'],
            ['Virginia', 'Cobalt', 1995, 1, '2015-07-06', null],
            ['Mark', 'Cuban', 1976, 0, '2014-04-01', null],
            ['Marsha', 'Rodriguez', 1989, 1, '2016-01-31', null],
            ['Donald', 'The Duck', 1971, 0, '2017-10-09', '2018-01-16'],
            ['Paris', 'Ritz', 1995, 1, '2018-03-01', null],
        ];
        $count = count($employees);

        # Loop through each employee, adding them to the database
        foreach ($employees as $employeeData) {
            $employee = new Employee();

            $employee->created_at = Carbon::now()->subDays($count)->toDateTimeString();
            $employee->updated_at = Carbon::now()->subDays($count)->toDateTimeString();
            $employee->first_name = $employeeData[0];
            $employee->last_name = $employeeData[1];
            $employee->birth_year = $employeeData[2];
            $employee->gender = $employeeData[3];
            $employee->employment_date = $employeeData[4];
            $employee->termination_date = $employeeData[5] ? $employeeData[5] : NULL;

            $employee->save();

            $count--;
        }
    }
}