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
                <form id="editportfolioForm" method="POST" action="{{ route('portfolio-update', $editPortfolio->id) }}"
                    enctype="multipart/form-data">
                    @csrf

                    @method('PUT')
                    <div class="row gx-5 mb-5">
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="project_name" placeholder="Enter Name"
                                    name="project_name" aria-label="Full Name" value="{{ $editPortfolio->project_name ?? '' }}">
                                <label for="name">Project name</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="sort_disc"
                                    name="sort_disc" aria-label="sort_disc" value="{{ $editPortfolio->sort_disc ?? '' }}">
                                <label for="sort_disc">Sort disc</label>
                            </div>
                        </div>
                    </div>
                    <div class="row gx-5 mb-5 mt-3">
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <input type="number" class="form-control" id="project_complete_year" placeholder="Enter Number"
                                    name="project_complete_year" aria-label="Phone Number" value="{{ $editPortfolio->project_complete_year ?? '' }}">
                                <label for="number">Project complete year</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="technology" placeholder="Enter Number"
                                    name="technology" aria-label="Phone Number" value="{{ $editPortfolio->technology ?? '' }}">
                                <label for="number">Technology</label>
                            </div>
                        </div>
                    </div>
                    <div class="row gx-5 mb-5 mt-5">
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <input type="file" class="form-control" id="project_image" placeholder="Enter Number"
                                    name="project_image" aria-label="Phone Number" value="{{ $editPortfolio->project_image ?? '' }}">
                                <label for="number">Project image</label>
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
            $('#editportfolioForm').on('submit', function(event) {
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
                            text: 'portfolio Update successfully!'
                        }).then(function() {
                            window.location.href = "{{ route('portfolio-list') }}";
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
