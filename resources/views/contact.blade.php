@extends('layouts.master')

@section('title')
    Contact Us
@endsection

@section('content')
    <h1>Contact Us</h1>

    @if(session('message'))
        <div class='alert alert-success'>
            {{ session('message') }}
        </div>
    @endif

    <p>Do you have questions about CCMS? Use the form below to let us know how we can help and we will get back to you as soon as possible.</p>
    <br>
    <form method='post' action='/contact'>
        {{ csrf_field() }}

        <div class="form-group">
            <label for="name">Name: </label>
            <input type="text" class="form-control" id="name" placeholder="Your name" name="name" required>
        </div>

        <div class="form-group">
            <label for="email">Email: </label>
            <input type="text" class="form-control" id="email" placeholder="john@example.com" name="email" required>
        </div>

        <div class="form-group">
            <label for="message">Message: </label>
            <textarea class="form-control luna-message" id="message" placeholder="Type your message here" name="message" required></textarea>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary" value="Send">Send</button>
        </div>
    </form>
@endsection