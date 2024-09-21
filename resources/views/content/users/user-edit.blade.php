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
                <form id="edituserForm" method="POST" action="{{ route('user-update', $editUser->id) }}"
                    enctype="multipart/form-data">
                    @csrf

                    @method('PUT')
                    <div class="row gx-5 mb-5">
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="name" placeholder="Enter Name"
                                    name="name" aria-label="Full Name" value="{{ $editUser->name ?? '' }}">
                                <label for="name">Full Name</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="email" placeholder="Enter Email"
                                    name="email" aria-label="Email" value="{{ $editUser->email ?? '' }}">
                                <label for="email">Email</label>
                            </div>
                        </div>
                    </div>
                    <div class="row gx-5 mb-5 mt-3">
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <input type="number" class="form-control" id="number" placeholder="Enter Number"
                                    name="number" aria-label="Phone Number" value="{{ $editUser->number ?? '' }}">
                                <label for="number">Number</label>
                            </div>
                        </div>

                    </div>
                    <div class="text-end mt-3">
                        <button type="submit" id="submitForm" class="btn btn-primary waves-effect waves-light">Save
                            Change</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#edituserForm').on('submit', function(event) {
                event.preventDefault();
                function isValidEmail(email) {
                    // Regular expression for basic email validation
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    return emailRegex.test(email);
                }
                var form = $(this);
                var url = form.attr('action');
                var formData = new FormData(this);
                // Assume `valid` is initially set to true
                let valid = true;
                var pattern = /^[a-zA-Z!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/? ]+$/;

                // Client-side validation

                const name=$('#name').val().trim(); 
                // Clear previous error messages and styles
                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').remove();
                // Validate name
                if ($('#name').val().trim() === '') {
                        $('#name').addClass('is-invalid');
                        $('#name').after('<div class="invalid-feedback">Name is required.</div>');
                        valid = false;
                    }
                else if(!pattern.test(name) && name !=''){
                        $('#name').addClass('is-invalid');
                                        $('#name').after('<div class="invalid-feedback">only alphabets are required</div>');
                                        valid = false;
                    }
           // Validate email
           const emailValue = $('#email').val().trim();
            if (emailValue === '') {
                $('#email').addClass('is-invalid');
                $('#email').after('<div class="invalid-feedback">Email is required.</div>');
                valid = false;
            } else if (!isValidEmail(emailValue)) {
                $('#email').addClass('is-invalid');
                $('#email').after('<div class="invalid-feedback">Please enter a valid email address.</div>');
                valid = false;
            }

            // Validate number
            if ($('#number').val().trim() === '') {
                $('#number').addClass('is-invalid');
                $('#number').after('<div class="invalid-feedback">Number is required.</div>');
                valid = false;
            }

            if (!valid) {
    // Prevent form submission or handle accordingly
    return; // Use this line to prevent form submission if inside a form submit handler
}
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'User Update successfully!'
                        }).then(function() {
                            window.location.href = "{{ route('user-list') }}";
                        });
                    },
                    error: function(response) {
                        let errors = response.responseJSON.errors;
                        let errorMessage = '';
                        for (let key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                errorMessage += errors[key][0] + '\n';
                            }
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage
                        });
                    }
                });
            });
        });
    </script>

@endsection
