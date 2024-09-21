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
                                <input type="text" class="form-control" id="name" 
                                    name="name" aria-label="Full Name">
                                <label for="name">Full Name</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="email" placeholder="Enter Email"
                                    name="email" aria-label="Email">
                                <label for="email">Email</label>
                            </div>
                        </div>
                    </div>
                    <div class="row gx-5 mb-5 mt-3">
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <input type="number" class="form-control" id="number" 
                                    name="number" aria-label="Phone Number">
                                <label for="number">Number</label>
                            </div>
                        </div>
                        <div class="col">
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
                function isValidEmail(email) {
                    // Regular expression for basic email validation
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    return emailRegex.test(email);
                }
                                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                var formData = new FormData(this);
                
               // Assume `valid` is initially set to true
                let valid = true;
                var pattern = /^[a-zA-Z ]+$/;
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

    // Validate password
    //const passwordValue = $('#password').val().trim();
    const passwordValue=$('#password').val().trim();  
                const hasLowercase = /[a-z]/.test(passwordValue);
                const hasUppercase = /[A-Z]/.test(passwordValue);
                const hasNumbers = /\d/.test(passwordValue);
                const hasSpecial = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(passwordValue);
    if (passwordValue === '') {
        $('#password').addClass('is-invalid');
        $('#password').after('<div class="invalid-feedback">Password is required.</div>');
        valid = false;
    } 

    else if (!hasLowercase || !hasUppercase || !hasNumbers || !hasSpecial) {

        $('#password').addClass('is-invalid');
        $('#password').after('<div class="invalid-feedback">Password must contain at least one lowercase letter, one uppercase letter, one number, and one special character</div>');
        valid = false;
   
  }

  else if (passwordValue.length < 6) {
        $('#password').addClass('is-invalid');
        $('#password').after('<div class="invalid-feedback">Password must be at least 6 characters long.</div>');
        valid = false;
    }

if (!valid) {
    // Prevent form submission or handle accordingly
    return; // Use this line to prevent form submission if inside a form submit handler
}

// Proceed with form submission or other logic if valid

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
                        Swal.fire({
                            title: 'Error!',
                            text: xhr.responseJSON.message || 'An error occurred.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });

            });
        });
    </script>

<style>
        .is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 0.875em;
        }
       
   
        </style>
   
       



@endsection
