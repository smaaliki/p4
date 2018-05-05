@extends('layouts.master')

@section('title')
    Sample Size Calculator
@endsection

@section('content')

    <h1>Contact Center Calculators >> Sample Size</h1>

    <form method='GET' action='/calculators/sampleSize'>
        {{ csrf_field() }}

        <div class='form-group row'>
            <label for='numCalls' class='col-sm-3 col-form-label'>Number of Contacts*</label>
            <input type='text' id='numCalls' name='numCalls' class='col-sm-4' value='{{ $numCalls or old('numCalls', '') }}'>
            @include('modules.error-field',['field' => 'numCalls'])
            <br>
        </div>
        <div class='form-group row'>
            <label for='confLevel' class='col-sm-3 col-form-label'>Confidence Level<br></label>
            @if (isset($confLevel))
                <input type='radio' name='confLevel' value='1' {{ ($confLevel == 1) ? 'CHECKED' : ''}}> 80%
                <input type='radio' name='confLevel' value='2' {{ ($confLevel == 2) ? 'CHECKED' : ''}}> 85%
                <input type='radio' name='confLevel' value='3' {{ ($confLevel == 3) ? 'CHECKED' : ''}}> 90%
                <input type='radio' name='confLevel' value='4' {{ ($confLevel == 4) ? 'CHECKED' : ''}}> 95%
                <input type='radio' name='confLevel' value='5' {{ ($confLevel == 5) ? 'CHECKED' : ''}}> 99%
            @else
                <input type='radio' name='confLevel' value='1' {{ ((old('confLevel',4) ) == 1) ? 'CHECKED' : ''}}> 80%
                <input type='radio' name='confLevel' value='2' {{ ((old('confLevel',4) ) == 2) ? 'CHECKED' : ''}}> 85%
                <input type='radio' name='confLevel' value='3' {{ ((old('confLevel',4) ) == 3) ? 'CHECKED' : ''}}> 90%
                <input type='radio' name='confLevel' value='4' {{ ((old('confLevel',4) ) == 4) ? 'CHECKED' : ''}}> 95%
                <input type='radio' name='confLevel' value='5' {{ ((old('confLevel',4) ) == 5) ? 'CHECKED' : ''}}> 99%
            @endif
            <br>
        </div>
        <div class='form-group row'>
            <label for='errorMargin' class='col-sm-3 col-form-label'>Margin of Error (%)*</label>
            <input type='text' id='errorMargin' name='errorMargin' class='col-sm-4' value='{{ $errorMargin or old('errorMargin', 5) }}'>
            @include('modules.error-field',['field' => 'errorMargin'])
            <br>
        </div>
        <div class='form-group row'><small class='form-text text-muted'>* Required fields</small>
</div>
        <!--<input class='btn btn-primary' type='submit' value='Submit'/>-->
        <button type='submit' class='btn btn-primary'>Submit</button>

    </form>

    @include('modules.error-form')

    @if (isset($sampleSize))
        <br>
        <p class='outMessage'>Your survey sample size should be {{ $sampleSize }}.</p>
    @endif

@endsection