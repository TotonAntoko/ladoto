@extends('frontEnd.layouts.master')

@section('title', 'Login')

@section('content')
    <!---start-wrap---->
    
    <!--- start-content---->
    <div class="content login-box">
        <div class="login-main">
            <div class="wrap">
                <h1>LOGIN OR CREATE AN ACCOUNT</h1>
                <div class="login-left">
                    <h3>NEW CUSTOMERS</h3>
                    <p>By creating an account with our store, you will be able to move through the checkout process
                        faster, store multiple shipping addresses, view and track your orders in your account and more.
                    </p>
                    <a class="acount-btn" href="/register">Creat an Account</a>
                </div>
                <div class="login-right">
                    <h3>REGISTERED CUSTOMERS</h3>
                    <p>If you have an account with us, please log in.</p>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div>
                            <span>Email Address<label>*</label></span>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        </div>
                        <div>
                            <span>Password<label>*</label></span>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        </div>
                        <a class="forgot" href="#">Forgot Your Password?</a>
                        <button type="submit">Login</button>
                    </form>
                </div>
                <div class="clear"> </div>
            </div>
        </div>
    </div>
    <!--- //End-content---->
    
    <!---//End-wrap---->
@endsection
