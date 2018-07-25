@extends('layouts.master')

@section('title')
    Contact Centers Standards
@endsection

@section('content')
    <h1>Contact Center Standards</h1>

    @if(count($standards) > 0)

<p> Your CC Score is {{$ccs}} </p>

        <form method='POST' action='/standards/calculate'>
        {{ csrf_field() }}
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">

                @foreach($perspectives as $count => $perspective)
                    <li class="nav-item">
                        <a @if($count == 0)
                           class="nav-link active"
                           aria-selected="true"
                           @else
                           class="nav-link"
                           aria-selected="false"
                           @endif
                           id="{{ $perspective->id }}-tab"
                           data-toggle="tab"
                           href="#{{ $perspective->id }}"
                           role="tab"
                           aria-controls="{{ $perspective->id }}">
                            {{$perspective->pillar->abbreviation}} - {{ $perspective->name }}
                        </a>
                    </li>

                @endforeach
            </ul>
            <div class="tab-content" id="myTabContent">
                @foreach($perspectives as $count => $perspective)
                    <div @if($count == 0) class="tab-pane fade show active" @else class="tab-pane fade" @endif
                         id="{{ $perspective->id }}" role="tabpanel" aria-labelledby="{{ $perspective->id }}-tab">
                        <h3>{{$perspective->pillar->abbreviation}} - {{ $perspective->name }}</h3>
                        @foreach ($focus_areas as $focus_area)
                            @if($focus_area->perspective_id == $perspective->id)

                                <h4>
                                    {{ $focus_area->fa_id . ' ' . $focus_area->name }}
                                </h4>
                                @if(($focus_area->id <10) && (!$touchpoints[$focus_area->id]))
                                <p>This focus area is not applicable. </p>
                                @else
                                <table class="table">
                                    <?php /*<caption>
                                        {{ $focus_area->fa_id . ' ' . $focus_area->name }}
                                    </caption> */ ?>
                                    <thead>
                                    <tr>
                                        <th>Std Num</th>
                                        <th>Standard</th>
                                        <th>Type</th>
                                        <th>Target</th>
                                        <th>Weight</th>
                                        <th>Achieved</th>
                                        <th>Performance</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($standards as $standard)
                                        @if($standard->focusarea->name == $focus_area->name)
                                            <tr class="{{$standard->std_type == 1 ? 'blueColor':'greyColor'}}">
                                                <td>{{ $standard->std_num }}</td>
                                                <td>{{ $standard->name_en }}</td>
                                                <td>{{ $standard->std_type==1? 'Standard':'Indicator' }}</td>

                                                <!--Todo: add unique names and ids that can be used in calculation -->
                                                @if ($standard->std_type == 1)
                                                    @if ($standard->target_type ==0)
                                                        <td>Yes or No</td>
                                                    @elseif($standard->target_type == 1)
                                                        <td>>= {{$standard->target_min}} {!! $standard->units=="m2"? 'm<sup>2</sup>':$standard->units !!}</td>
                                                    @elseif($standard->target_type == 2)
                                                        <td>{{$standard->target_min}} to {{$standard->target_max}}  {!! $standard->units=="m2"? 'm<sup>2</sup>':$standard->units !!}</td>
                                                    @elseif($standard->target_type == 3)
                                                        <td><= {{$standard->target_max}} {!! $standard->units=="m2"? 'm<sup>2</sup>':$standard->units !!}</td>
                                                    @else
                                                        <td>Error</td>
                                                    @endif

                                                    <td align='right'>{{ number_format($standard->weight, 2, '.', ',') }}%</td>
                                                @else
                                                    <td>{!! $standard->units=="m2"? 'm<sup>2</sup>':$standard->units !!}</td>
                                                    <td></td>
                                                @endif

                                                @if ($standard->target_type ==0)
                                                    <td align='right'><label class=" switch">
                                                            <input type="checkbox"
                                                                   id="{{'achieved'.str_replace('.', '_',  $standard->std_num) }}"
                                                                   name="{{'achieved'.str_replace('.', '_',  $standard->std_num) }}"
                                                                    {{ (old('achieved'.str_replace('.', '_',  $standard->std_num) , $standard->achieved) == 1) ? 'checked' : '' }}>
                                                            <span class="slider round"></span>
                                                        </label></td>
                                                @else
                                                    <td align='right'><input type="text"
                                                                             class="form-control"
                                                                             id="{{'achieved'.str_replace('.', '_',  $standard->std_num) }}"
                                                                             placeholder="Value"
                                                                             name="{{'achieved'.str_replace('.', '_',  $standard->std_num) }}"
                                                                             value='{{ old('achieved'.str_replace('.', '_',  $standard->std_num) , $standard->achieved) }}'>
                                                    </td>
                                                @endif
                                                @if ($standard->std_type == 1)
                                                    <td align='right'>{{ number_format($standard->performance, 2, '.', ',') }}%</td>
                                                @else
                                                    <td></td>
                                                @endif
                                            </tr>
                                        @endif
                                    @endforeach
                                    <tr>
                                        <td></td>
                                        <td>{{ $focus_area->name }}</td>
                                        <td></td>
                                        <td></td>
                                        <td align='right'>{{ number_format($focus_area->weight, 2, '.', ',') }}%</td>
                                        <td></td>
                                        <td align='right'>{{number_format($focus_area->result, 2, '.', ',') }}%</td>
                                    </tr>
                                    </tbody>
                                </table>
                                @endif
                            @endif
                        @endforeach
                    </div>
                @endforeach
            </div>
            <button type='submit' class='btn btn-primary'>Calculate</button>
        </form>
        <a class='add_new_cc' href='/standards/reset'>Reset</a>

        <?php /*

        <form method='POST' action='/standards/calculate'>
            {{ csrf_field() }}
            @foreach($pillars as $pillar)
                <h2>{{$pillar->name}}</h2>
                @foreach($perspectives as $perspective)
                    @if($perspective->pillar_id == $pillar->id)
                        <h3>{{$perspective->name}}</h3>
                        @foreach ($focus_areas as $focus_area)
                            @if($focus_area->perspective_id == $perspective->id)

                                <table class="table">
                                    <caption>
                                        {{ $focus_area->fa_id . ' ' . $focus_area->name }}
                                    </caption>
                                    <thead>
                                    <tr>
                                        <th>Std Num</th>
                                        <th>Standard</th>
                                        <th>Type</th>
                                        <th>Target</th>
                                        <th>Weight</th>
                                        <th>Achieved</th>
                                        <th>Performance</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($standards as $standard)
                                        @if($standard->focusarea->name == $focus_area->name)
                                            <tr class="{{$standard->std_type == 1 ? 'blueColor':'greyColor'}}">
                                                <td>{{ $standard->std_num }}</td>
                                                <td>{{ $standard->name_en }}</td>
                                                <td>{{ $standard->std_type==1? 'Standard':'Indicator' }}</td>

                                                <!--Todo: add unique names and ids that can be used in calculation -->
                                                @if ($standard->std_type == 1)
                                                    @if ($standard->target_type ==0)
                                                        <td>Yes or No</td>
                                                    @elseif($standard->target_type == 1)
                                                        <td>>= {{$standard->target_min}} {!! $standard->units=="m2"? 'm<sup>2</sup>':$standard->units !!}</td>
                                                    @elseif($standard->target_type == 2)
                                                        <td>{{$standard->target_min}} to {{$standard->target_max}}  {!! $standard->units=="m2"? 'm<sup>2</sup>':$standard->units !!}</td>
                                                    @elseif($standard->target_type == 3)
                                                        <td><= {{$standard->target_max}} {!! $standard->units=="m2"? 'm<sup>2</sup>':$standard->units !!}</td>
                                                    @else
                                                        <td>Error</td>
                                                    @endif

                                                    <td>{{ number_format($standard->weight, 2, '.', ',') }}%</td>
                                                @else
                                                    <td>{!! $standard->units=="m2"? 'm<sup>2</sup>':$standard->units !!}</td>
                                                    <td></td>
                                                @endif

                                                @if ($standard->target_type ==0)
                                                    <td align='right'><label class=" switch">
                                                            <input type="checkbox"
                                                                   id="{{'achieved'.str_replace('.', '_',  $standard->std_num) }}"
                                                                   name="{{'achieved'.str_replace('.', '_',  $standard->std_num) }}"
                                                                    {{ (old('achieved'.str_replace('.', '_',  $standard->std_num) , $standard->achieved) == 1) ? 'checked' : '' }}>
                                                            <span class="slider round"></span>
                                                        </label></td>
                                                @else
                                                    <td align='right'><input type="text"
                                                                             class="form-control"
                                                                             id="{{'achieved'.str_replace('.', '_',  $standard->std_num) }}"
                                                                             placeholder="Value"
                                                                             name="{{'achieved'.str_replace('.', '_',  $standard->std_num) }}"
                                                                             value='{{ old('achieved'.str_replace('.', '_',  $standard->std_num) , $standard->achieved) }}'>
                                                    </td>
                                                @endif
                                                @if ($standard->std_type == 1)
                                                    <td align='right'>{{ number_format($standard->performance, 4, '.', ',') }}%</td>
                                                @else
                                                    <td></td>
                                                @endif
                                            </tr>
                                        @endif
                                    @endforeach
                                    <tr>
                                        <td></td>
                                        <td>{{ $focus_area->name }}</td>
                                        <td></td>
                                        <td></td>
                                        <td align='right'>{{ number_format($focus_area->weight, 4, '.', ',') }}%</td>
                                        <td></td>
                                        <td align='right'>{{number_format($focus_area->result, 4, '.', ',') }}%</td>
                                    </tr>
                                    </tbody>
                                </table>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            @endforeach

            <button type='submit' class='btn btn-primary'>Calculate</button>
        </form>
        <a class='add_new_cc' href='/standards/reset'>Reset</a>
*/ ?>
        <table class="table">
            <caption>
                Results
            </caption>
            <thead>
            <tr>
                <th>Focus Area</th>
                <th>Achieved</th>
                <th>Weight</th>
                <th>Result</th>
            </tr>
            </thead>
            <tbody>
            @foreach($perspectives as $perspective)
                <tr class='blueColor'>
                    <td>{{$perspective->name}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @foreach ($focus_areas as $focusarea)
                    @if($focusarea->perspective_id == $perspective->id)
                        <tr>
                            <td>{{$focusarea->name }}</td>
                            <td align='right'>{{ number_format( $focusarea->achieved, 2, '.', ',') }}</td>
                            <td align='right'>{{ number_format( $focusarea->weight, 2, '.', ',') }}</td>
                            <td align='right'>{{ number_format( ($focusarea->result * $focusarea->weight)/100, 2, '.', ',') }}</td>
                        </tr>
                    @endif
                @endforeach
                <tr class='greyColor'>
                    <td>{{$perspective->name}} Results</td>
                    <td align='right'>{{ number_format($perspective->achieved, 2, '.', ',') }}</td>
                    <td align='right'>{{ number_format($perspective->weight, 2, '.', ',') }}</td>
                    <td align='right'>{{ number_format($perspective->result, 2, '.', ',') }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endforeach
            </tbody>
        </table>

        @include('modules.error-form')
    @endif
@endsection

@push('script')
    <link href='/css/theme.grey.min.css' type='text/css' rel='stylesheet'>
    <script src="/js/jquery-3.2.1.min.js"></script>
    <script src="/js/jquery.tablesorter.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#stdTable").tablesorter({
                theme: 'grey',
                widgets: ['zebra'],
                sortList: [[0, 0]]
            });
        });
    </script>
@endpush