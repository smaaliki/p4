@extends('layouts.master')

@section('title')
    Manage Contact Centers
@endsection

@section('content')
    <h1>Our Contact Centers</h1>

    @if(count($ccs) > 0)

        <p>Below is a list of all of the government contact centers operating in our city.</p>
        @foreach($ccs as $cc)
            <div class='cc_show'>
                <h2>{{ $cc->name }}</h2>
                <div>{{ $cc->street_address }}</div>
                <div>{{ $emirates[$cc->emirate] }}</div>
                <div class='phone_num'>{{ $cc->phone_number }}</div> <!--todo: make sure that this is clickable on a mobile-->
            </div>
        @endforeach
    @endif
@endsection
