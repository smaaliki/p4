@extends('layouts.master')

@section('title')
    Manage Employees
@endsection

@section('content')
    <h1>Manage Employees</h1>

    @if(count($employees) > 0)
        <table id="ccTable" class="tablesorter">
            <caption>
                You can edit employees or deactivate them by clicking on the respective icon in the Actions column in the table below.  To add a new employee, click on the link below the table.
            </caption>
            <thead>
            <tr>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Gender</th>
                <th>Birth Year</th>
                <th>Employment Date</th>
                <th>Termination Date</th>
                <th>Contact Center</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($employees as $employee)
                <tr>
                    <td>{{ $employee->last_name }}</td>
                    <td>{{ $employee->first_name }}</td>
                    <td>{{ $employee->gender? 'Female': 'Male'}}</td>
                    <td>{{ $employee->birth_year }}</td>
                    <td>{{ $employee->employment_date }}</td>
                    <td>{{ $employee->termination_date }}</td>
                    <td>{{ $employee->contactcenter->name }}</td>
                    <td>
                        <a href='/manageEmployees/{{ $employee->id }}/edit'><img class='actions_icon' src='/images/edit.png' alt='Edit Employee'></a>
                        <a href='/manageEmployees/{{ $employee->id }}/delete'><img class='actions_icon' src='/images/delete.png' alt='Deactivate Employee'></a>  <!-- Todo: Replace with a deactivate icon -->
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
    <a class='add_new_cc' href='/manageEmployees/create'>Add New Employee</a>
@endsection

@push('script')
    <link href='/css/theme.grey.min.css' type='text/css' rel='stylesheet'>
    <script src="/js/jquery-3.2.1.min.js"></script>
    <script src="/js/jquery.tablesorter.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#ccTable").tablesorter({
                theme: 'grey',
                widgets: ['zebra'],
                sortList: [[0, 0]]
            });
        });
    </script>
@endpush
