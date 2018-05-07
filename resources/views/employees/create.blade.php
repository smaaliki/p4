@extends('layouts.master')

@section('title')
    Manage Employees
@endsection

@section('content')
    <h1> Manage Employees</h1>

    <h2>Add New Employee</h2>

    <form method='POST' action='/manageEmployees/store'>
        {{ csrf_field() }}

        <div class="form-group row">
            <div class='details'>* Required fields</div>
        </div>

        <div class="form-group row">
            <label class='col-sm-3 col-form-label' for='firstName'>First Name *</label>
            <div class='col-sm-10'>
                <input type='text'
                       class='form-control'
                       name='firstName'
                       id='firstName'
                       value='{{ old('firstName', '') }}'>
            </div>
        </div>
        @include('modules.error-field', ['field' => 'firstName'])

        <div class="form-group row">
            <label class='col-sm-3 col-form-label' for='lastName'>Last Name *</label>
            <div class='col-sm-10'>
                <input type='text'
                       class='form-control'
                       name='lastName'
                       id='lastName'
                       value='{{ old('lastName', '') }}'>
            </div>
        </div>
        @include('modules.error-field', ['field' => 'lastName'])

        <div class="form-group row">
            <label class='col-sm-3 col-form-label' for='birthYear'>Birth Year</label>
            <div class='col-sm-10'>
                <input type='text'
                       class='form-control'
                       name='birthYear'
                       id='birthYear'
                       value='{{ old('birthYear', '') }}'>
            </div>
        </div>
        @include('modules.error-field', ['field' => 'birthYear'])

        <div class="form-check form-check-inline">
            <input class="form-check-input"
                   type="radio"
                   name="gender"
                   id="inlineRadio1"
                   value='1' {{ old('gender', 1)? 'checked':'' }}>
            <label class="form-check-label" for="inlineRadio1">Female</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input"
                   type="radio"
                   name="gender"
                   id="inlineRadio2"
                   value='0' {{ old('gender', 1)? '':'checked' }}>
            <label class="form-check-label" for="inlineRadio2">Male</label>
        </div>

        <div class="form-group row">
            <label class='col-sm-3 col-form-label' for='employmentDate'>Employment Date *</label>
            <div class='col-sm-10'>
                <input type='date'
                       class='form-control'
                       name='employmentDate'
                       id='employmentDate'
                       value='{{ old('employmentDate', '') }}'>
            </div>
        </div>
        @include('modules.error-field', ['field' => 'employmentDate'])

        <div class="form-group row">
            <label class='col-sm-3 col-form-label' for='terminationDate'>Termination Date</label>
            <div class='col-sm-10'>
                <input type='date'
                       class='form-control'
                       name='terminationDate'
                       id='terminationDate'
                       value='{{ old('terminationDate', '') }}'>
            </div>
        </div>

        <button type='submit' class='btn btn-primary'>Add</button>
    </form>

    @include('modules.error-form')

@endsection