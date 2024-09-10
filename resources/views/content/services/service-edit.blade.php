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
            <form action="{{ route('service-update', $editService->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT') 

    <div class="row gx-5 mb-5 mt-3">
        <div class="col">
            <div class="form-floating form-floating-outline">
                <div class="mb-3">
                    <!-- Display the current image if it exists -->
                    @if(isset($editService->image) && !empty($editService->image))
                        <img src="{{ asset($editService->image) }}" alt="Current Image" style="width: 150px; height: auto;">
                    @endif
                </div>
                <!-- <label for="image" class="mt-1">Service Image</label> -->
                <input type="file" class="form-control" id="image" name="image" aria-label="Image">
               
            </div>
        </div>
    </div>

    <!-- Other form fields for name and description -->
    <div class="row gx-5 mb-5 mt-3">
        <div class="col">
            <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $editService->service_name) }}" required>
                <label for="name">Service Name</label>
            </div>
        </div>
    </div>

    <div class="row gx-5 mb-5 mt-3">
        <div class="col">
            <div class="form-floating form-floating-outline">
                <textarea class="form-control" id="description" name="description" required>{{ old('description', $editService->sort_desc) }}</textarea>
                <label for="description">Description</label>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
</form>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#editserviceForm').on('submit', function(event) {
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
                            text: 'Service Update successfully!'
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
