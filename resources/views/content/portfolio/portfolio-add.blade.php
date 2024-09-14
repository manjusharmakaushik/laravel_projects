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
        <!-- portfolio Information -->
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Add portfolio Information</h5>
            </div>
            <div class="card-body">
                <form id="portfolioForm">
                    @csrf
                    <div class="row gx-5 mb-5">
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="project_name"
                                    name="project_name" aria-label="Full Name">
                                <label for="name">Project Name</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="sort_disc" 
                                    name="sort_disc" aria-label="sort_disc">
                                <label for="sort_disc">Sort disc</label>
                            </div>
                        </div>
                    </div>
                    <div class="row gx-5 mb-5 mt-3">
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <input type="number" class="form-control" id="project_complete_year"
                                    name="project_complete_year" aria-label="Phone Number" >
                                <label for="number">Project complete year</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="technology" 
                                    name="technology" aria-label="technology" >
                                <label for="technology">Technology</label>
                            </div>
                        </div>
                    </div>
                    <div class="row gx-5 mb-5 mt-5">
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <input type="file" class="form-control" id="project_image"
                                    name="project_image" aria-label="project_image" >
                                <label for="project_image">Project image</label>
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
            $('#portfolioForm').on('submit', function(e) {
                e.preventDefault(); // Prevent form submission

                $.ajax({
                    url: "{{ route('portfolio-store') }}", // Laravel route for storing portfolio data
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'portfolio added successfully!'
                        }).then(function() {
                            window.location.href = "{{ route('portfolio-list') }}";
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
