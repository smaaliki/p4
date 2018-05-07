@extends('layouts.master')

@section('title')
    Add Contact Center
@endsection

@section('content')
    <h1>Manage Contact Centers</h1>

    <h2>Add a New Contact Center</h2>

    <form method='POST' action='/manageCCs/store'>
        {{ csrf_field() }}

        <div class="form-group row">
            <div class='details'>* Required fields</div>
        </div>

        <div class="form-group row">
            <label class='col-sm-3 col-form-label' for='ccName'>Name *</label>
            <div class='col-sm-10'>
                <input type='text' class='form-control' name='ccName' id='ccName' value='{{ old('ccName', '') }}'>
            </div>
            @include('modules.error-field', ['field' => 'ccName'])
        </div>

        <div class="form-group row">
            <label class='col-sm-3 col-form-label' for='address'>Address</label>
            <div class='col-sm-10'>
                <input type='text' class='form-control' name='address' id='address' value='{{ old('address', '') }}'>
            </div>
            @include('modules.error-field', ['field' => 'address'])
        </div>

        <div class="form-group row">
            <label class='col-sm-3 col-form-label' for='emirate'>District *</label>
            <div class='col-sm-10'>
                <select id='emirate' name='emirate' class='form-control'>
                    @foreach($emirates as $numeric => $string)
                        <option value='{{ $numeric }}' {{ (old('emirate', '3') == $numeric) ? 'SELECTED' : '' }}>{{ $string }}</option>
                    @endforeach
                </select>
            </div>
            @include('modules.error-field', ['field' => 'emirate'])
        </div>

        <div class="form-group row">
            <label class='col-sm-3 col-form-label' for='phoneNumber'>Phone Number *</label>
            <div class='col-sm-10'>
                <input type='text'
                       class='form-control'
                       maxlength='22'
                       name='phoneNumber'
                       id='phoneNumber'
                       value='{{ old('phoneNumber', '') }}'>
            </div>
            @include('modules.error-field', ['field' => 'phoneNumber'])
        </div>

        <button type='submit' class='btn btn-primary'>Add CC</button>
    </form>

    @include('modules.error-form')

@endsection