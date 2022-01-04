@extends('layouts.app')

@section('content')
<script src='https://www.google.com/recaptcha/api.js'></script>
<body style="background-color:  #1d5b99 !important; background-image: none;">


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
        
            <div class="card mt-5" style="border-radius: 20px !important;" >
                <div class="card-header" align="center">{{ __('Login') }}</div>
                <div class="row mt-5 mb-5" >

                    <div class="col-md-4" align="right">

                                 <img src="{{url('/')}}/uploads/userimage/who-LOGO.png"   alt="logo_img" width="200px"/>
                            <!--<img src="{{url('/')}}/img/678.jpg" class="login-img">-->
                            <div class="md_left_imgtext">
                                <!---<p>A Sample and intelligent to-do list that makes it easy to plan your day</p>-->
                            </div>
                    </div>
                    <div class="col-md-8" align="left" >
                        

                        <div class="card-body">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                    <div class="col-md-8">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                    <div class="col-md-8">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right"></label>
                                    <div class="col-md-8">
                                        @if(config('services.recaptcha.key'))
                                            <div required class=" mt-3 g-recaptcha"
                                                data-sitekey="{{config('services.recaptcha.key')}}">
                                            </div>
                                        @endif
                                        {!! app('captcha')->display() !!}
                                @if ($errors->has('g-recaptcha-response'))
                                    <span class="help-block" style="color: red; ">
                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                    </span>
                                @endif
                                    </div>
                                </div>




                                 
                                <div class="form-group row">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Login') }}
                                        </button>

                                        @if (Route::has('password.request'))
                                           <a href="{{url('forgotpassword')}}" class="custom-control-description forgottxt_clr">Forgot password?</a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{!! NoCaptcha::renderJs() !!}
@endsection
