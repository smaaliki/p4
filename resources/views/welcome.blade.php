@extends('layouts.master')

@section('title')
    Home
@endsection

@section('content')
    <h1>Contact Centers Management System</h1>

    <p> Welcome! This is the centralized portal for all of the contact centers at Gotham City.
        Sometimes, it can get confusing as to which number to call for questions about trash pickup,
        license renewals, inspections, crime reporting, etc. By using the link above you can view
        a list of all of our CCs and find their phone numbers.</p>
    <p> If you are the manager one of these contact centers, you can manage your center's contact information
        and manage your employees.
    </p>

    <h2>Features</h2>

    <h3>Contact Center Management</h3>
    <p>As a CC Admin, you can add and edit your center's employees by using the Manage CCs link above.</p>

    <h3>Agent Management</h3>
    <p>As a CC Admin, you can add and edit your center's employees by using the Employees Link above.</p>

    <h3>Coming Soon</h3>
    <p>Below is a list of the features that we will be adding in the near future. If you have any other suggestions,
       or features that you would like to see, please use the Contact form.
    </p>
    <ul>
        <li>Service Listing per CC for the public</li>
        <li>Employee Classification</li>
        <li>CC Operational Tools</li>
        <li>Monthly Agent Quiz</li>
        <li>Finance Tracking Sheets</li>
    </ul>
@endsection