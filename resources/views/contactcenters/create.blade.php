@extends('layouts.master')

@section('title')
    Add Contact Center
@endsection

@section('content')
    <h1>Manage Contact Centers</h1>

    <h2>Add a New Contact Center</h2>

    <form method='POST' action='/manageCCs/store'>
        {{ csrf_field() }}

        @include('contactcenters.ccFormInputs')

        <button type='submit' class='btn btn-primary'>Add CC</button>
    </form>

    @include('modules.error-form')

@endsection