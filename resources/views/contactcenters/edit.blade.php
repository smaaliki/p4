@extends('layouts.master')

@section('title')
    Edit Contact Center
@endsection

@section('content')
    <h1>Manage Contact Centers</h1>

    <h2>Edit {{$cc->name}}</h2>

    <form method='POST' action='/manageCCs/{{ $cc->id }}'>
        {{ method_field('put') }}
        {{ csrf_field() }}

        @include('contactcenters.ccFormInputs')

        <button type='submit' class='btn btn-primary'>Save</button>
    </form>

    @include('modules.error-form')

@endsection