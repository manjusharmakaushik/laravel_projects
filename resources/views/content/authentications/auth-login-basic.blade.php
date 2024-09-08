    @extends('layouts/blankLayout')

    @section('title', 'Login')

    @section('page-style')
        @vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
    @endsection

    @section('content')
        <div class="position-relative">
            <div class="authentication-wrapper authentication-basic container-p-y">
                <div class="authentication-inner py-6 mx-4">

                    <!-- Login -->
                    <div class="card p-7">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mt-5">
                            <a href="{{ url('/') }}" class="app-brand-link gap-3">
                                <span class="app-brand-logo demo">@include('_partials.macros', ['height' => 20, 'withbg' => 'fill: #fff;'])</span>
                                <span class="app-brand-text demo text-heading fw-semibold">Cipher Web Infotech</span>
                            </a>
                        </div>
                        <!-- /Logo -->

                        <div class="card-body mt-1">
                            <h4 class="mb-1">Welcome to Cipher Web Infotech 👋🏻</h4>
                            <p class="mb-5">Please sign-in to your account and start the adventure</p>
                            <!-- Add this section to your form -->
                            <div id="loginErrors" class="alert alert-danger d-none" role="alert"></div>

                            <form id="formAuthentication" class="mb-5">
                                <!-- Existing form fields -->
                                <div class="form-floating form-floating-outline mb-5">
                                    <input type="text" class="form-control" id="email" name="email-username"
                                        placeholder="Enter your email or username" autofocus>
                                    <label for="email">Email or Username</label>
                                </div>
                                <div class="mb-5">
                                    <div class="form-password-toggle">
                                        <div class="input-group input-group-merge">
                                            <div class="form-floating form-floating-outline">
                                                <input type="password" id="password" class="form-control" name="password"
                                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                    aria-describedby="password" />
                                                <label for="password">Password</label>
                                            </div>
                                            <span class="input-group-text cursor-pointer"><i
                                                    class="ri-eye-off-line ri-20px"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-5 pb-2 d-flex justify-content-between pt-2 align-items-center">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" id="remember-me">
                                        <label class="form-check-label" for="remember-me">
                                            Remember Me
                                        </label>
                                    </div>
                                    <a href="{{ url('auth/forgot-password-basic') }}" class="float-end mb-1">
                                        <span>Forgot Password?</span>
                                    </a>
                                </div>
                                <div class="mb-5">
                                    <button id="loginButton" class="btn btn-primary d-grid w-100"
                                        type="button">Login</button>
                                </div>
                            </form>


                            <p class="text-center mb-5">
                                <span>New on our platform?</span>
                                <a href="{{ url('auth/register-basic') }}">
                                    <span>Create an account</span>
                                </a>
                            </p>
                        </div>
                    </div>
                    <!-- /Login -->
                    <img src="{{ asset('assets/img/illustrations/tree-3.png') }}" alt="auth-tree"
                        class="authentication-image-object-left d-none d-lg-block">
                    <img src="{{ asset('assets/img/illustrations/auth-basic-mask-light.png') }}"
                        class="authentication-image d-none d-lg-block" height="172" alt="triangle-bg">
                    <img src="{{ asset('assets/img/illustrations/tree.png') }}" alt="auth-tree"
                        class="authentication-image-object-right d-none d-lg-block">
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- SweetAlert2 CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>


        <script>
            $(document).ready(function() {
                $('#loginButton').on('click', function(e) {
                    e.preventDefault();

                    // Get form data
                    var emailUsername = $('#email').val();
                    var password = $('#password').val();
                    var rememberMe = $('#remember-me').is(':checked') ? 1 : 0;

                    $.ajax({
                        url: '{{ route('loginCheck') }}', // Update this with the route you have for login
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}', // Include CSRF token
                            email_username: emailUsername,
                            password: password,
                            remember_me: rememberMe
                        },
                        success: function(response) {
                            if (response.success) {
                                // Swal.fire({
                                //     icon: 'success',
                                //     title: 'Success',
                                //     text: 'User Login successfully!'
                                // }).then(function() {
                                window.location.href = response
                                    .redirect_url;

                                // });
                            } else {
                                alert(response.message);
                                $('#loginErrors').removeClass('d-none').text(response.message);

                            }
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText); // Log error for debugging
                            $('#loginErrors').removeClass('d-none').text(response.message);

                        }
                    });
                });
            });
        </script>

    @endsection
