@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Testimonial Management')

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
                <h5 class="card-title mb-0">Edit Testimonial Information</h5>
            </div>

            <div class="card-body">
                <form id="editTestimonialForm" method="POST" action="{{ route('testimonial-update', $editTestimonial->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row gx-5 mb-5">
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="testimonial_name" placeholder="Enter Testimonial Name"
                                    name="testimonial_name" aria-label="Testimonial Name" value="{{ $editTestimonial->testimonial_name ?? '' }}">
                                <label for="testimonial_name">Testimonial Name</label>
                            </div>
                        </div>
                
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="sort_desc" placeholder="Enter Short Description"
                                    name="sort_desc" aria-label="Short Description" value="{{ $editTestimonial->sort_desc ?? '' }}">
                                <label for="sort_desc">Short Description</label>
                            </div>
                        </div>

                        <div class="row gx-5 mb-5 mt-3"></div>
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <input type="file" class="form-control" id="testimonial_image" name="testimonial_image">
                                <label for="testimonial_image">Testimonial Image</label>
                                @if(!empty($editTestimonial->testimonial_image))
                                    <div class="mt-2">
                                        <img src="{{ asset('uploads/testimonials/' . $editTestimonial->testimonial_image) }}" alt="Testimonial Image" style="width:100px; height:auto;">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-floating form-floating-outline">
                            <select class="form-select" id="status" name="status" aria-label="Testimonial Status">
                                <option value="1" {{ $editTestimonial->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $editTestimonial->status == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            <label for="status">Status</label>
                        </div>
                    </div>
                    
                    <div class="text-end mt-3">
                        <button type="submit" id="submitForm" class="btn btn-primary waves-effect waves-light">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#editTestimonialForm').on('submit', function(event) {
                event.preventDefault();

                var form = $(this);
                var url = form.attr('action');
                var formData = new FormData(this);

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
                            text: 'Testimonial updated successfully!'
                        }).then(function() {
                            window.location.href = "{{ route('testimonial-list') }}";
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
