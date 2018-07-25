<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\ContactCenter;

class EmployeeController extends Controller
{
    /* Show the list of employees*/
    public function index()
    {
        $employees = Employee::with('contactcenter')->get();

        return view('employees.manageEmployees')->with([
            'employees' => $employees,
        ]);
    }

    /* Show the form to add a new employee */
    public function create()
    {
        $ccs = ContactCenter::orderBy('name')->get();

        return view('employees.create')->with([
            'ccs' => $ccs,
            'employee' => new Employee(),
        ]);
    }

    /* Process the addition of the new employee */
    public function store(Request $request)
    {
        $messages = [
            'firstName.required' => 'The First Name is required',
            'lastName.required' => 'The Last Name is required',
            'birthYear.numeric' => 'Birth Year can only consist of number digits',
            'birthYear.digits' => 'Birth Year must consist of 4 digits',
            'employmentDate.required' => 'Employment Date is required'
        ];

        $this->validate($request, [
            'firstName' => 'required',
            'lastName' => 'required',
            'birthYear' => 'nullable|numeric|digits:4',
            'employmentDate' => 'required',
        ], $messages);

        $cc = ContactCenter::where('id', '=', $request->contactcenter)->first();

        # Save the employee to the database
        $employee = new Employee();
        $employee->last_name = $request->lastName;
        $employee->first_name = $request->firstName;
        $employee->gender = $request->gender;
        $employee->birth_year = $request->birthYear;
        $employee->employment_date = $request->employmentDate;
        $employee->termination_date = $request->terminationDate;
        $employee->contactCenter()->associate($cc);
        $employee->save();

        # Send the user back to the page to add an employee; include the title as part of the redirect
        # so we can display a confirmation message on that page
        return redirect('/manageEmployees/create')->with([
            'alert' => 'The employee ' . $employee->first_name . ' ' . $employee->last_name . ' was added.'
        ]);
    }

    /* Show the form to edit an employee */
    public function edit($id)
    {
        /*Todo: rename this to cc */
        $ccs = ContactCenter::orderBy('name')->get();

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
            'ccs' => $ccs,
        ]);
    }

    /* Update the employee */
    public function update(Request $request, $id)
    {
        $messages = [
            'firstName.required' => 'The First Name is required',
            'lastName.required' => 'The Last Name is required',
            'birthYear.numeric' => 'Birth Year can only consist of number digits',
            'birthYear.digits' => 'Birth Year must consist of 4 digits',
            'employmentDate.required' => 'Employment Date is required'
        ];

        $this->validate($request, [
            'firstName' => 'required',
            'lastName' => 'required',
            'birthYear' => 'nullable|numeric|digits:4',
            'employmentDate' => 'required',
        ], $messages);

        # Fetch the employee we want to update
        $employee = Employee::find($id);

        # Find the contact center that the employee works for.
        $contact_center = ContactCenter::where('id', '=', $request->contactcenter)->first();

        # Update data
        $employee->last_name = $request->lastName;
        $employee->first_name = $request->firstName;
        $employee->gender = $request->gender;
        $employee->birth_year = $request->birthYear;
        $employee->employment_date = $request->employmentDate;
        $employee->termination_date = $request->terminationDate;
        $employee->contactCenter()->associate($contact_center);//cc_id = $request->contactcenter;
        $employee->save();

        # Send the user back to the edit page in case they want to make more edits
        return redirect('/manageEmployees/' . $id . '/edit')->with([
            'alert' => 'Your changes were saved'
        ]);
    }

    /* Delete an employee from teh database */
    public function remove($id)
    {
        $removedEmployee = Employee::where('id', '=', $id)->first();

        if (!$removedEmployee) {
            $employees = Employee::orderBy('last_name')->get();

            return redirect('/employees')->with([
                'employees' => $employees,
                'alert' => 'The employee was not found!',
            ]);
        } else {
            $removedEmployee->delete();

            $employees = Employee::orderBy('last_name')->get();

            return redirect('/employees')->with([
                'employees' => $employees,
                'alert' => 'The employee ' . $removedEmployee->first_name . ' ' . $removedEmployee->last_name . ' was removed',
            ]);
        }
    }
}