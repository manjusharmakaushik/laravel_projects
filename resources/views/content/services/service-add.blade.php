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
        <!-- Service Information -->
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Add Service Information</h5>
            </div>
            <div class="card-body">
                <form id="serviceForm" enctype="multipart/form-data" action="{{ route('service-store') }}" method="POST">
                    @csrf
                    <div class="row gx-5 mb-5">
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="name" placeholder="Enter Services Name"
                                    name="name" aria-label="Full Name">
                                <label for="name">Services Name</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating form-floating-outline">
                                <input type="file" name="image" placeholder="Choose image" aria-label="Choose Image"
                                    id="image" class="form-control">
                                <label for="image">Image</label>
                                <!-- Image preview container -->
                                <div class="mt-3">
                                    <img id="imagePreview" src="#" alt="Image preview"
                                        style="display: none; width: 50%; max-height: 100px; object-fit: cover;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row gx-5 mb-5">
                        <div class="col-sm-6">
                            <textarea id="description" name="description" class="form-control" placeholder="Short Description"
                                aria-label="Short Description" aria-describedby="basic-icon-default-message2"></textarea>
                        </div>
                    </div>

            </div>
            <div class="text-end my-5 mx-5">
                <button type="submit" id="submitForm" class="btn btn-primary waves-effect waves-light">Save</button>
            </div>
            </form>
        </div>
    </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#serviceForm').on('submit', function(e) {
                e.preventDefault();

                // Clear previous error styles
                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                var formData = new FormData(this);

                var valid = true;

                // Client-side validation
                if ($('#name').val().trim() === '') {
                    $('#name').addClass('is-invalid');
                    $('#name').after('<div class="invalid-feedback">Service Name is required.</div>');
                    valid = false;
                }

                if ($('#image')[0].files.length === 0) {
                    $('#image').addClass('is-invalid');
                    $('#image').after('<div class="invalid-feedback">Image is required.</div>');
                    valid = false;
                }

                if ($('#description').val().trim() === '') {
                    $('#description').addClass('is-invalid');
                    $('#description').after('<div class="invalid-feedback">Description is required.</div>');
                    valid = false;
                }

                if (!valid) return;

                $.ajax({
                    url: "{{ route('service-store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Service added successfully!'
                        }).then(function() {
                            window.location.href = "{{ route('service-list') }}";
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

            // Handle image preview
            $('#image').on('change', function(event) {
                var file = event.target.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagePreview').attr('src', e.target.result).show();
                    };
                    reader.readAsDataURL(file);
                } else {
                    $('#imagePreview').attr('src', '#').hide();
                }
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
