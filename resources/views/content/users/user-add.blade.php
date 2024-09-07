@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

@section('vendor-style')
    @vite('resources/assets/vendor/libs/apex-charts/apex-charts.scss')
@endsection

@section('vendor-script')
    @vite('resources/assets/vendor/libs/apex-charts/apexcharts.js')
@endsection

@section('page-script')
    @vite('resources/assets/js/dashboards-analytics.js')
@endsection

@section('content')

    <div class="col-12 col-lg-12">
        <!-- User Information -->
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Add User Information</h5>
            </div>
            <div class="card-body">
                <form id="userForm">
                    @csrf
                    <div class="row gx-5 mb-5">
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="name" placeholder="Enter Name"
                                    name="name" aria-label="Full Name">
                                <label for="name">Full Name</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <input type="email" class="form-control" id="email" placeholder="Enter Email"
                                    name="email" aria-label="Email">
                                <label for="email">Email</label>
                            </div>
                        </div>
                    </div>
                    <div class="row gx-5 mb-5 mt-3">
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <input type="number" class="form-control" id="number" placeholder="Enter Number"
                                    name="number" aria-label="Phone Number">
                                <label for="number">Number</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <input type="password" class="form-control" id="password"
                                    placeholder="Enter Minimum 6 digit password" name="password" aria-label="Password">
                                <label for="password">Password</label>
                            </div>
                        </div>
                    </div>
                    <div class="text-end mt-3">
                        <button type="submit" id="submitForm"
                            class="btn btn-primary waves-effect waves-light">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#userForm').on('submit', function(e) {
                e.preventDefault(); // Prevent form submission
                let isValid = true;

                // Clear any previous validation messages
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').hide();

                // Name field validation
                if ($('#name').val().trim() === '') {
                    $('#name').addClass('is-invalid');
                    $('#name').next('.invalid-feedback').show();
                    isValid = false;
                }

                // Email field validation
                if ($('#email').val().trim() === '') {
                    $('#email').addClass('is-invalid');
                    $('#email').next('.invalid-feedback').show();
                    isValid = false;
                }

                // Number field validation
                if ($('#number').val().trim() === '') {
                    $('#number').addClass('is-invalid');
                    $('#number').next('.invalid-feedback').show();
                    isValid = false;
                }

                // Password field validation
                if ($('#password').val().trim() === '') {
                    $('#password').addClass('is-invalid');
                    $('#password').next('.invalid-feedback').show();
                    isValid = false;
                }

                // If form is valid, proceed with AJAX submission
                if (isValid) {
                    $.ajax({
                        url: "{{ route('user-store') }}", // Laravel route for storing user data
                        type: "POST",
                        data: $(this).serialize(),
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'User added successfully!'
                            }).then(function() {
                                window.location.href = "{{ route('user-list') }}";
                            });
                        },
                        error: function(xhr, status, error) {
                            // Display error alert if something goes wrong
                            Swal.fire({
                                title: 'Error!',
                                text: 'An error occurred: ' + xhr.responseText,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                } else {
                    // If form validation fails, display a validation error alert
                    Swal.fire({
                        title: 'Validation Error!',
                        text: 'Please fill in all required fields.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    </script>





@endsection
