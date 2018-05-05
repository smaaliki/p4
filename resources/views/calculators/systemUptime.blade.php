@extends('layouts.master')

@section('title')
    System Uptime Calculator
@endsection

@section('content')
    <!--Todo: work on the Styling of this form!!-->
    <h1>Contact Center Calculators >> System Uptime</h1>

    <form method='GET' action='/calculators/systemUptime'>
        {{ csrf_field() }}

        <label for='month'>Select Month and Year:
            <select name='month' id='month'>
                @if($month)
                    <option value='1' {{ ($month == 1) ? 'SELECTED' : ''}}>Jan</option>
                    <option value='2' {{ ($month == 2) ? 'SELECTED' : ''}}>Feb</option>
                    <option value='3' {{ ($month == 3) ? 'SELECTED' : ''}}>Mar</option>
                    <option value='4' {{ ($month == 4) ? 'SELECTED' : ''}}>Apr</option>
                    <option value='5' {{ ($month == 5) ? 'SELECTED' : ''}}>May</option>
                    <option value='6' {{ ($month == 6) ? 'SELECTED' : ''}}>Jun</option>
                    <option value='7' {{ ($month == 7) ? 'SELECTED' : ''}}>Jul</option>
                    <option value='8' {{ ($month == 8) ? 'SELECTED' : ''}}>Aug</option>
                    <option value='9' {{ ($month == 9) ? 'SELECTED' : ''}}>Sep</option>
                    <option value='10' {{ ($month == 10) ? 'SELECTED' : ''}}>Oct</option>
                    <option value='11' {{ ($month == 11) ? 'SELECTED' : ''}}>Nov</option>
                    <option value='12' {{ ($month == 12) ? 'SELECTED' : ''}}>Dec</option>
                @else
                    <option value='1' {{ (old('month',1) == 1) ? 'SELECTED' : ''}}>Jan</option>
                    <option value='2' {{ (old('month',1) == 2) ? 'SELECTED' : ''}}>Feb</option>
                    <option value='3' {{ (old('month',1) == 3) ? 'SELECTED' : ''}}>Mar</option>
                    <option value='4' {{ (old('month',1) == 4) ? 'SELECTED' : ''}}>Apr</option>
                    <option value='5' {{ (old('month',1) == 5) ? 'SELECTED' : ''}}>May</option>
                    <option value='6' {{ (old('month',1) == 6) ? 'SELECTED' : ''}}>Jun</option>
                    <option value='7' {{ (old('month',1) == 7) ? 'SELECTED' : ''}}>Jul</option>
                    <option value='8' {{ (old('month',1) == 8) ? 'SELECTED' : ''}}>Aug</option>
                    <option value='9' {{ (old('month',1) == 9) ? 'SELECTED' : ''}}>Sep</option>
                    <option value='10' {{ (old('month',1) == 10) ? 'SELECTED' : ''}}>Oct</option>
                    <option value='11' {{ (old('month',1) == 11) ? 'SELECTED' : ''}}>Nov</option>
                    <option value='12' {{ (old('month',1) == 12) ? 'SELECTED' : ''}}>Dec</option>
                @endif
            </select>
        </label>
        <label>
            <select name='year'>
                @if ($year)
                    <option value='2017' {{ ($year == '2017') ? 'SELECTED' : ''}}>2017</option>
                    <option value='2018' {{ ($year == '2018') ? 'SELECTED' : ''}}>2018</option>
                @else
                    <option value='2017' {{ (old('year',2018) == '2017') ? 'SELECTED' : ''}}>2017</option>
                    <option value='2018' {{ (old('year',2018) == '2018') ? 'SELECTED' : ''}}>2018</option>
                @endif
            </select>
        </label>
        <br>
        <label> Check if you have a 24/7 Operation
            <input type='checkbox'
                   name='fullOperation'
                   id='fullOperation'
                   value='1'
                    {{ ($fullOperation or old('fullOperation',false))  ? 'CHECKED' : '' }}
            >
        </label>
        <br>
        <!-- Todo: disable the following inputs if it is a 24/7 operation -->
        <label for='weekDayHours'>Work Hours per Week Day:
            <input type='range'
                   id='weekDayHours'
                   name='weekDayHours'
                   min='6'
                   value='{{ $weekDayHours or old('weekDayHours', 8) }}'
                   max='24'
                   step='1'
                   onchange="weekDayHoursOutput.value = this.value;">
        </label>

        <output id='weekDayHoursOutput'>{{ $weekDayHours or old('weekDayHours', 8) }}</output>
        <br>

        <label for='weekendWorkHours'>Work Hours per Weekend Day:
            <input type='range'
                   id='weekendWorkHours'
                   name='weekendWorkHours'
                   min='6'
                   value='{{ $weekendWorkHours or old('weekendWorkHours', 8) }}'
                   max='24'
                   step='1'
                   onchange="weekendWorkHoursOutput.value = this.value;">
        </label>
        <output id="weekendWorkHoursOutput">{{ $weekendWorkHours or old('weekendWorkHours', 8) }}</output>
        <br>
        <!-- Todo: The following does not work properly if the downTime is not entered.  Resets to defaults-->
        <!-- Todo: Figure out how to simplify the following-->
        <p id='weekDays'>* Select below the days of the week that your contact center is open for business:<br/>
            @if (isset($tempWorkDays))
                <input type='checkbox'
                       id='sunday'
                       name='workDays[]'
                       value='sunday' {{ $tempWorkDays[0] ? 'CHECKED' : '' }}> Sunday
                <input type='checkbox'
                       id='monday'
                       name='workDays[]'
                       value='monday' {{ $tempWorkDays[1] ? 'CHECKED' : '' }}> Monday
                <input type='checkbox'
                       id='tuesday'
                       name='workDays[]'
                       value='tuesday' {{ $tempWorkDays[2] ? 'CHECKED' : '' }}> Tuesday
                <input type='checkbox'
                       id='wednesday'
                       name='workDays[]'
                       value='wednesday' {{ $tempWorkDays[3] ? 'CHECKED' : '' }}> Wednesday
                <input type='checkbox'
                       id='thursday'
                       name='workDays[]'
                       value='thursday' {{ $tempWorkDays[4] ? 'CHECKED' : '' }}> Thursday
                <input type='checkbox'
                       id='friday'
                       name='workDays[]'
                       value='friday' {{ $tempWorkDays[5] ? 'CHECKED' : '' }}> Friday
                <input type='checkbox'
                       id='saturday'
                       name='workDays[]'
                       value='saturday' {{ $tempWorkDays[6]   ? 'CHECKED' : '' }}> Saturday
            @else

                <input type='checkbox'
                       id='sunday'
                       name='workDays[]'
                       value='sunday' {{ (old('tempWorkDays.0',true)) ? 'CHECKED' : '' }}> Sunday
                <input type='checkbox'
                       id='monday'
                       name='workDays[]'
                       value='monday' {{ (old('tempWorkDays.1',true))  ? 'CHECKED' : '' }}> Monday
                <input type='checkbox'
                       id='tuesday'
                       name='workDays[]'
                       value='tuesday' {{ (old('tempWorkDays.2',true))  ? 'CHECKED' : '' }}> Tuesday
                <input type='checkbox'
                       id='wednesday'
                       name='workDays[]'
                       value='wednesday' {{ (old('tempWorkDays.3',true))  ? 'CHECKED' : '' }}> Wednesday
                <input type='checkbox'
                       id='thursday'
                       name='workDays[]'
                       value='thursday' {{ (old('tempWorkDays.4',true))  ? 'CHECKED' : '' }}> Thursday
                <input type='checkbox'
                       id='friday'
                       name='workDays[]'
                       value='friday' {{ (old('tempWorkDays.5',false))  ? 'CHECKED' : '' }}> Friday
                <input type='checkbox'
                       id='saturday'
                       name='workDays[]'
                       value='saturday' {{ (old('tempWorkDays.6',false))  ? 'CHECKED' : '' }}> Saturday
            @endif
        </p>
        @include('modules.error-field',['field' => 'workDays'])

        <label for='downTime'>* System Shutdown Time (hrs):
            <input type='text' id='downTime' name='downTime' value='{{ $downTime or old('downTime','') }}'>
        </label>
        @include('modules.error-field',['field' => 'downTime'])

        <br>
        <br>
        <div class='details'>* Required fields</div>
        <input class='button' type='submit' value='Submit'/>

    </form>

    @include('modules.error-form')

    @if (isset($systemUpTime))
        <br>
        <p class='outMessage'>Total Work Hours for the month: {{ $monthWorkHours }} hours</p>
        <p class='outMessage'>System Up Time for the month: {{ $systemUpTime }}%</p>
    @endif

@endsection