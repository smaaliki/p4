<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::orderBy('last_name')->get();

        return view('employees.manageEmployees')->with([
            'employees' => $employees,
        ]);
    }

    /*
    **
    * Show the form to edit an existing employee
    */
    public function edit($id)
    {
        # Find the employee center the visitor is requesting to edit
        $employee = Employee::find($id);

        # Handle the case where we can't find the given employee
        if (!$employee) {
            return redirect('/manageEmployees')->with(
                ['alert' => 'Employee ' . $id . ' not found.']
            );
        }

        # Show the contact employee edit form
        return view('employees.edit')->with([
            'employee' => $employee,
        ]);
    }

    /**
     * Process the form to edit an existing contact employee
     * PUT /employee center/{id}
     */
    public function update(Request $request, $id)
    {
        //dd($request);
        $this->validate($request, [
            'firstName' => 'required',
            'lastName' => 'required',
            'birthYear' => 'numeric|digits:4',
            'employmentDate' => 'required',
        ]);

        # Fetch the contact employee we want to update
        $employee = Employee::find($id);

        # Update data
        $employee->last_name = $request->firstName;
        $employee->first_name = $request->lastName;
        $employee->gender = $request->gender;
        $employee->birth_year = $request->birthYear;
        $employee->employment_date = $request->employmentDate;
        $employee->termination_date = $request->terminationDate;
        $employee->save();

        # Send the user back to the edit page in case they want to make more edits
        return redirect('/manageEmployees/' . $id . '/edit')->with([
            'alert' => 'Your changes were saved'
        ]);
    }
}