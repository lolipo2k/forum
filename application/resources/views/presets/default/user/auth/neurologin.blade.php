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
                        <h2 class="welcome-text">Авторизация через нейроскрайб</h2>
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
                            <input type="hidden" name="neuroscribe" value="1">
                            <button class="btn btn--base wow animate__animated animate__fadeInUp" data-wow-delay="0.5s">@lang('Login')</button>
                        </form>
                        <p class="pt-3 wow animate__animated animate__fadeInUp" data-wow-delay="0.6s">
                            <a href="{{ route('user.login') }}" class="text--base">Авторизоваться через аккаунт форума</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection