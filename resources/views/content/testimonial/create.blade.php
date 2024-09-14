@extends('layouts/contentNavbarLayout')

@section('title', 'Add Testimonial')

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
        <!-- Testimonial Information -->
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Add Testimonial Information</h5>
            </div>
            <div class="card-body">
                <form id="testimonialForm">
                    @csrf
                    <div class="row gx-5 mb-5">
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="testimonial_name" placeholder="Enter Testimonial Name"
                                    name="testimonial_name" aria-label="Testimonial Name">
                                <label for="testimonial_name">Testimonial Name</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="sort_desc" placeholder="Enter Description"
                                    name="sort_desc" aria-label="Short Description">
                                <label for="sort_desc">Short Description</label>
                            </div>
                        </div>
                    </div>
                    <div class="row gx-5 mb-5 mt-3">
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <input type="file" class="form-control" id="testimonial_image" name="testimonial_image"
                                    aria-label="Testimonial Image">
                                <label for="testimonial_image">Testimonial Image</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <select class="form-select" id="status" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                <label for="status">Status</label>
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
            $('#testimonialForm').on('submit', function(e) {
                e.preventDefault(); // Prevent form submission

                // Create a FormData object for file upload
                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('testimonial-store') }}", 
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Testimonial added successfully!'
                        }).then(function() {
                            window.location.href = "{{ route('testimonial-list') }}";
                        });
                    },
                    error: function(xhr, status, error) {
                        // Display error alert if something goes wrong
                        Swal.fire({
                            title: 'Error!',
                            text: xhr.responseText,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });

            });
        });
    </script>

@endsection
