@extends('layouts.master')

@section('title')
    Manage Employees
@endsection

@section('content')
    <h1> Manage Employees</h1>

    <h2>Edit {{$employee->first_name . ' ' . $employee->last_name}}</h2>

    <form method='POST' action='/manageEmployees/{{ $employee->id }}'>
        {{ method_field('put') }}
        {{ csrf_field() }}

        @include('employees.employeeFormInputs')

        <button type='submit' class='btn btn-primary'>Save</button>
    </form>

    @include('modules.error-form')

@endsection