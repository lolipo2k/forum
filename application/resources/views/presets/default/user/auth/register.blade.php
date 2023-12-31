@extends($activeTemplate . 'layouts.frontend')
@section('content')
@php
$policyPages = getContent('policy_pages.element', false, null, true);
$credentials = $general->socialite_credentials;
@endphp

<div class="modal fade" id="existModalCenter" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
                <span class="close" data-bs-dismiss="modal">
                    <i class="las la-times"></i>
                </span>
            </div>
            <div class="modal-body">
                <h6 class="text-center">@lang('You already have an account please Login ')</h6>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal">@lang('Close')</button>
                <a href="{{ route('user.login') }}" class="btn btn--base btn-sm">@lang('Login')</a>
            </div>
        </div>
    </div>
</div>

@include('presets.default.components.header')
<section class="signup-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-12">
                <div class="log-in-box wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                    <div class="sign-up_box wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                        <h3 class="title wow animate__animated animate__fadeInUp" data-wow-delay="0.3s">
                            @lang('Please SignUp')
                        </h3>
                        <form action="{{ route('user.register') }}" method="POST" class="verify-gcaptcha">
                            @csrf
                            <div class="row wow animate__animated animate__fadeInUp" data-wow-delay="0.4s">
                                <div class="col-lg-12 mb-3">
                                    <div class="form-group">
                                        <input class="form--control checkUser" placeholder="" name="username" value="{{ old('username') }}" required>
                                        <label class="form--label">@lang('User Name') </label>
                                        <small class="text-danger usernameExist"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row wow animate__animated animate__fadeInUp" data-wow-delay="0.5s">
                                <div class="col-lg-12 mb-3">
                                    <div class="form-group">
                                        <input class="form--control mb-3 checkUser" placeholder="" name="email" value="{{ old('email') }}">
                                        <label class="form--label">@lang('Email')</label>
                                        <small class="text-danger emailExist"></small>
                                    </div>
                                </div>
                            </div>

                            <div class="row wow animate__animated animate__fadeInUp" data-wow-delay="0.7s">
                                <div class="col-xxl-6 col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <input class="form--control mb-3" placeholder="" name="password" type="password">
                                        <label class="form--label">@lang('Password')</label>
                                        @if ($general->secure_password)
                                        <div class="input-popup">
                                            <p class="error lower">@lang('1 small letter minimum')</p>
                                            <p class="error capital">@lang('1 capital letter minimum')</p>
                                            <p class="error number">@lang('1 number minimum')</p>
                                            <p class="error special">@lang('1 special character minimum')</p>
                                            <p class="error minimum">@lang('6 character password')</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-lg-6 col-md-6 mb-3">
                                    <div class="form-group">
                                        <input class="form--control mb-3" placeholder="" name="password_confirmation" type="password">
                                        <label class="form--label">@lang('Re-Enter Password')</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row wow animate__animated animate__fadeInUp" data-wow-delay="0.8s">
                                <div class="col-xxl-12 col-lg-12 col-md-12 mb-3">
                                    <div class="form-group">
                                        <x-captcha></x-captcha>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 form--check wow animate__animated animate__fadeInUp" data-wow-delay="0.9s">
                                @if ($general->agree)
                                <div class="form-group checkbox-group">
                                    <input class="form-check-input" type="checkbox" id="agree" @checked(old('agree')) name="agree" required>
                                    <label for="agree">Я согласен @foreach ($policyPages as $policy)
                                        <a class="text--base" href="{{ route('policy.pages', [slug($policy->data_values->title), $policy->id]) }}">{{ __($policy->data_values->title) }}</a>
                                        @if (!$loop->last)
                                        ,
                                        @endif
                                        @endforeach
                                    </label>
                                </div>
                                @endif
                            </div>
                            <button class="btn btn--base wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">Регистрация</button>
                        </form>


                        {{-- social box --}}
                        <div class="social-option">
                            <div class="text">
                                <h6>или</h6>
                            </div>
                            <p>
        Войдите через учётную запись нейроскрайба
    </p>
                            <ul class="login-with">
                                <li class="single-button">
                                    <a href="{{ route('user.neurologin') }}">
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

<!-- / sign-in section -->


@endsection
@push('style')
<style>
    .country-code .input-group-text {
        background: #fff !important;
    }

    .country-code select {
        border: none;
    }

    .country-code select:focus {
        border: none;
        outline: none;
    }
</style>
@endpush
@push('script-lib')
<script src="{{ asset('assets/common/js/secure_password.js') }}"></script>
@endpush
@push('script')
<script>
    "use strict";
    (function($) {
        @if($mobileCode)
        $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
        @endif

        $('select[name=country]').change(function() {
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
        });
        $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
        $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
        $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));

        @if($general->secure_password)
        $('input[name=password]').on('input', function() {
            secure_password($(this));
        });

        $('[name=password]').focus(function() {
            $(this).closest('.form-group').addClass('hover-input-popup');
        });

        $('[name=password]').focusout(function() {
            $(this).closest('.form-group').removeClass('hover-input-popup');
        });
        @endif

        $('.checkUser').on('focusout', function(e) {
            var url = '{{ route('user.checkUser') }}';
            var value = $(this).val();
            var token = '{{ csrf_token() }}';
            if ($(this).attr('name') == 'mobile') {
                var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                var data = {
                    mobile: mobile,
                    _token: token
                }
            }
            if ($(this).attr('name') == 'email') {
                var data = {
                    email: value,
                    _token: token
                }
            }
            if ($(this).attr('name') == 'username') {
                var data = {
                    username: value,
                    _token: token
                }
            }
            $.post(url, data, function(response) {
                if (response.data != false && response.type == 'email') {
                    $(`.${response.type}Exist`).text(`${response.type} уже существует`);
                    $('#existModalCenter').modal('show');
                } else if (response.data != false) {
                    let name = (response.type == "username") ? "такое имя" : response.type;
                    $(`.${response.type}Exist`).text(`${name} уже существует`);
                } else {
                    $(`.${response.type}Exist`).text('');
                }
            });
        });
    })(jQuery);
</script>
@endpush