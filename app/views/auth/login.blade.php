@extends('layouts.auth')

@section('content')

    <div class="row">

        <div class="col-1-2">
        
        {{ Form::open() }}
    
            <div class="form-row">
    
                {{ Form::label('Username') }}
                {{ Form::text('username') }}
    
            </div>
    
            <div class="form-row">
    
                {{ Form::label('Password') }}
                {{ Form::password('password') }}
    
            </div>


                {{ Form::hidden('public_token', Input::get('public_token')) }}
                {{ Form::hidden('redirect_url', Input::get('redirect_url')) }}

    
            <div class="form-row">
    
                {{ Form::submit('Login') }}
    
            </div>
    
        {{ Form::close() }}

        </div>

        <div class="col-1-2 pad-left">
            <p>You are trying to login to an app the uses <span class="beer-api">beer api</span>, please login with us and we will pass on your details.</p>
    
            <p><b>We will never pass on your password.</b></p>
        </div>

    </div>

@stop