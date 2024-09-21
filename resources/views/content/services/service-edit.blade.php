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
                <h5 class="card-title mb-0">Edit Service Information</h5>
            </div>

            <div class="card-body">
                <form id="editserviceForm" action="{{ route('service-update', $editService->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Service Name -->
                    <div class="row gx-5 mb-5">
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" placeholder="Enter Services Name" name="name" aria-label="Full Name"
                                    value="{{ old('name', $editService->service_name ?? '') }}">
                                <label for="name">Services Name</label>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Image Upload and Preview -->
                        <div class="col-sm-6">
                            <div class="form-floating form-floating-outline">
                                <input type="file" name="image" id="image"
                                    class="form-control @error('image') is-invalid @enderror" aria-label="Choose Image">
                                <label for="image">Image</label>

                                <!-- Image preview container -->
                                <div class="mt-3">
                                    <!-- Display the current image if it exists -->
                                    @if ($editService->image && file_exists(public_path($editService->image)))
                                        <!-- Display the current image if it exists -->
                                        <img src="{{ asset($editService->image) }}" id="currentImage" alt="Current Image" style="width: 150px; height: auto;">
                                    @else
                                        <!-- Display the default "no image" placeholder -->
                                        <img src="{{ asset('assets/def-image/no-image.png') }}" id="currentImage"  class=" waves-light" alt="No Image Available" style="width: 100px; height: auto;border:2px solid grey;">
                                    @endif
                                    <!-- Preview the new image -->
                                    <img id="imagePreview" src="" alt="Image preview"
                                        style="display: none; width: 150px; height: auto; object-fit: cover;">
                                </div>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Short Description -->
                    <div class="row gx-5 mb-5">
                        <div class="col-sm-6">
                            <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror"
                                placeholder="Short Description" aria-label="Short Description">{{ old('description', $editService->sort_desc ?? '') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>

            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Function to clear previous validation messages
            function clearValidationErrors() {
                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').remove();
            }

            // Preview selected image before submission
            $('#image').on('change', function() {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        $('#imagePreview').attr('src', event.target.result).show();
                        $('#currentImage')
                            .hide(); // Hide the current image when a new image is selected
                    }
                    reader.readAsDataURL(file);
                } else {
                    $('#imagePreview').hide();
                    $('#currentImage').show(); // Show the current image if no new file is selected
                }
            });

            // Handle form submission with AJAX
            $('#editserviceForm').on('submit', function(event) {
                event.preventDefault();

                clearValidationErrors(); // Clear previous validation messages

                var form = $(this);
                var url = form.attr('action');
                var formData = new FormData(this);

                var valid = true;
                var pattern = /^[a-zA-Z!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/? ]+$/;
                const name=$('#name').val().trim();  
                // Client-side validation
                if ($('#name').val().trim() === '') {
                    $('#name').addClass('is-invalid');
                    $('#name').after('<div class="invalid-feedback">Service Name is required.</div>');
                    valid = false;
                }
                else if(!pattern.test(name) && name !=''){
                    $('#name').addClass('is-invalid');
                                    $('#name').after('<div class="invalid-feedback">only alphabets are required</div>');
                                    valid = false;
                }
                if ($('#image')[0].files.length === 0 && !$('#currentImage').attr('src')) {
                    $('#image').addClass('is-invalid');
                    $('#image').after('<div class="invalid-feedback">Image is required.</div>');
                    valid = false;
                }

                else if ($('#image')[0].files.length > 0) {
                    const file = $('#image')[0].files[0];
                    const fileType = file.type;

                    if (fileType === 'image/gif') {
                        $('#image').addClass('is-invalid');
                        $('#image').after('<div class="invalid-feedback">GIF images are not allowed.</div>');
                        valid = false;
                    }
                }

                if ($('#description').val().trim() === '') {
                    $('#description').addClass('is-invalid');
                    $('#description').after('<div class="invalid-feedback">Description is required.</div>');
                    valid = false;
                }

                if (!valid) return;

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
                            text: 'Service updated successfully!'
                        }).then(function() {
                            window.location.href = "{{ route('service-list') }}";
                        });
                    },
                    error: function(response) {
                        let errors = response.responseJSON.errors;
                        let errorMessage = '';
                        for (let key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                errorMessage += errors[key][0] + '\n';
                                $('#' + key).addClass('is-invalid');
                                $('#' + key).after('<div class="invalid-feedback">' + errors[
                                    key][0] + '</div>');
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
