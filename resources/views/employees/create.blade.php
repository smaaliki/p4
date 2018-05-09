@extends('layouts.master')

@section('title')
    Manage Employees
@endsection

@section('content')
    <h1> Manage Employees</h1>

    <h2>Add New Employee</h2>

    <form method='POST' action='/manageEmployees/store'>
        {{ csrf_field() }}

        @include ('employees.employeeFormInputs')

        <button type='submit' class='btn btn-primary'>Add</button>
    </form>

    @include('modules.error-form')

@endsection