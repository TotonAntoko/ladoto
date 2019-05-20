@extends('frontEnd.layouts.master')

@section('title', 'Register')

@section('content')
	<!---start-wrap---->
	
	<!--- start-content---->
	<div class="content login-box">
		<div class="login-main">
			<div class="wrap">
				<h1>CREATE AN ACCOUNT</h1>
				<div class="register-grids">
					<form method="POST" action="{{ route('register') }}">
                        @csrf
						<div class="register-top-grid">
							<h3>PERSONAL INFORMATION</h3>
							<div>
								<span>Username<label>*</label></span>
								{{-- <input type="text"> --}}
								<input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

								@error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>
							
							<div>
								<span>Email Address<label>*</label></span>
								<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

								@error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>
							<div class="clear"> </div>
							<a class="news-letter" href="#">
								<label class="checkbox"><input type="checkbox" name="checkbox" checked=""><i> </i>Sign
									Up for Newsletter</label>
							</a>
							<div class="clear"> </div>
						</div>
						<div class="clear"> </div>
						<div class="register-bottom-grid">
							<h3>LOGIN INFORMATION</h3>
							<div>
								<span>Password<label>*</label></span>
								<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

								@error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>
							<div>
								<span>Confirm Password<label>*</label></span>
								<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
							</div>
							<div class="clear"> </div>
						</div>
						<div class="clear"> </div>
						{{-- <input type="submit" value="submit" /> --}}
						<button type="submit">Register</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<!--- //End-content---->
	
    <!---//End-wrap---->
@endsection