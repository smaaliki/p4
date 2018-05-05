@extends('layouts.master')

@section('title')
    CC Calculators
@endsection

@section('content')
    <h1>List of Contact Center Calculators</h1>

    @foreach($methods as $method)
        <a href='\calculators\{{ $method }}'> {{ str_replace('_', ' ', str_replace('_Calc', '', $method)) }}</a><br>
    @endforeach

@endsection