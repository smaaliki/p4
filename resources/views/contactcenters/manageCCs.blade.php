@extends('layouts.master')

@section('title')
    Manage Contact Centers
@endsection

@section('content')
    <h1>Manage Contact Centers</h1>

    @if(count($ccs) > 0)
        <table id="ccTable" class="tablesorter">
            <caption>
                You can edit or delete each contact center, by clicking on the respective icon in the Actions column  in the table below.  To add a new contact center, click on the link below the table.
            </caption>
            <thead>
            <tr>
                <th>Contact Center</th>
                <th>Phone Number</th>
                <th>Address</th>
                <th>District</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($ccs as $cc)
                <tr>
                    <td>{{ $cc->name }}</td>
                    <td>{{ $cc->phone_number }}</td>
                    <td>{{ $cc->street_address }}</td>
                    <td>{{ $emirates[$cc->emirate] }}</td>
                    <td id='actions_column'>
                        <a href='/manageCCs/{{ $cc->id }}/edit'><img class='actions_icon' src='/images/edit.png' alt='Edit Contact Center'></a>
                        <a href='/manageCCs/{{ $cc->id }}/delete'><img class='actions_icon' src='/images/delete.png' alt='Delete Contact Center'></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

    <a class='add_new_cc' href='/manageCCs/create'>Add New CC</a>
@endsection

@push('script')
    <link href='/css/theme.grey.min.css' type='text/css' rel='stylesheet'>
    <script src="/js/jquery-3.2.1.min.js"></script>
    <script src="/js/jquery.tablesorter.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#ccTable").tablesorter({
                theme: 'grey',
                widgets: ['zebra'],
                sortList: [[0, 0]]
            });
        });
    </script>
@endpush
