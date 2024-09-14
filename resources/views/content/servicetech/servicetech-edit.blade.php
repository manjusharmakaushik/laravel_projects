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
                <h5 class="card-title mb-0">Edit Service tech Category</h5>
            </div>

            <div class="card-body">
                <form id="editServicetechForm" action="{{ route('service-tech-update', $editServicetech->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Service Name -->
                    <div class="row gx-5 mb-5">
                        <div class="col">
                        <div class="form-floating form-floating-outline">
                                <select name="service_id" class="form-control" id="service_id" required>
                                    <option value="">Select Category</option>
                                    @foreach ($service_tech_categories as $service_tech_category)
                                        <option value="{{ $service_tech_category->service_id }}" {{ $editServicetech->service_id == $service_tech_category->service_id ? 'selected' : '' }}>{{ $service_tech_category->service_name }}</option>
                                    @endforeach
                                </select>
                                <label for="name">Services Tech Category</label>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" placeholder="Enter Services Name" name="name" aria-label="Full Name"
                                    value="{{ old('name', $editServicetech->name ?? '') }}">
                                <label for="name">Services Tech Category</label>
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
                                    @if (isset($editServicetech->image) && !empty($editServicetech->image))
                                        <img src="{{ asset($editServicetech->image) }}" id="currentImage" alt="Current Image"
                                            style="width: 150px; height: auto;">
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
            $('#editServicetechForm').on('submit', function(event) {
                event.preventDefault();

                clearValidationErrors(); // Clear previous validation messages

                var form = $(this);
                var url = form.attr('action');
                var formData = new FormData(this);

                var valid = true;

                // Client-side validation
                if ($('#name').val().trim() === '') {
                    $('#name').addClass('is-invalid');
                    $('#name').after('<div class="invalid-feedback">Service Name is required.</div>');
                    valid = false;
                }

                if ($('#image')[0].files.length === 0 && !$('#currentImage').attr('src')) {
                    $('#image').addClass('is-invalid');
                    $('#image').after('<div class="invalid-feedback">Image is required.</div>');
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
                            window.location.href = "{{ route('service-tech-list') }}";
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
