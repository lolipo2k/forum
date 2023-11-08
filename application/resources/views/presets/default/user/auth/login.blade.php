@extends($activeTemplate . 'layouts.frontend')

@section('content')
@php
$credentials = $general->socialite_credentials;
@endphp
@include('presets.default.components.header')
<section class="login-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6">
                <div class="log-in-box">
                    <div class="login wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                        <h2 class="welcome-text">@lang('Welcome Back !')</h2>
                        <form method="POST" action="{{ route('user.login') }}">
                            @csrf
                            <div class="form-group pwow animate__animated animate__fadeInUp" data-wow-delay="0.3s">
                                <input type="text" placeholder=" " class="form--control mb-3" value="{{ old('username') }}" name="username">
                                <label class="form--label">@lang('Username or Email')</label>
                            </div>
                            <div class="form-group wow animate__animated animate__fadeInUp" data-wow-delay="0.3s">
                                <input type="password" placeholder=" " class="form--control mb-3 wow animate__animated animate__fadeInUp" data-wow-delay="0.4s" name="password">
                                <label class="form--label">@lang('Password')</label>
                            </div>
                            <div class="login-meta mb-3 wow animate__animated animate__fadeInUp" data-wow-delay="0.5s">
                                <div class="form--check">
                                    <input class="form-check-input" type="checkbox" value="" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">@lang('Remember Me')</label>
                                </div>
                                <a href="{{ route('user.password.request') }}" class="text--base">@lang('Forgot Password?')</a>
                            </div>
                            <button class="btn btn--base wow animate__animated animate__fadeInUp" data-wow-delay="0.5s">@lang('Login')</button>
                        </form>
                        <p class="pt-3 wow animate__animated animate__fadeInUp" data-wow-delay="0.6s">@lang("Don't Have An Account?")
                            <a href="{{ route('user.register') }}" class="text--base">@lang('Create Account')</a>
                        </p>
                        {{-- social box --}}
                        <div class="social-option">
                            <div class="text">
                                <h6>или</h6>
                            </div>
                            <ul class="login-with">
                                <li class="single-button">
                                    <a href="{{ route('user.social.login', 'google') }}">
                                        <img src="{{ asset('assets/images/frontend/login.png') }}" alt="">
                                    </a>
                                </li>
                            </ul>
                        </div>
                        {{-- social box --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection