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
                                <input type="email" class="form-control" id="email" placeholder="Enter Email"
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
