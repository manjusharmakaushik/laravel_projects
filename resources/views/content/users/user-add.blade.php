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
                <h5 class="card-title mb-0">Add User information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    @csrf
                    <div class="row gx-5 mb-5">
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="name" placeholder="Enter Name"
                                    name="name" aria-label="Product SKU">
                                <label for="name">Full Name</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <input type="email" class="form-control" id="email" placeholder="Enter Email"
                                    name="email" aria-label="email">
                                <label for="email">Email</label>
                            </div>
                        </div>
                    </div>
                    <div class="row gx-5 mb-5 mt-3">
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <input type="number" class="form-control" id="number" placeholder="Enter Number"
                                    name="number" aria-label="Product SKU">
                                <label for="number">Number</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <input type="password" class="form-control" id="password"
                                    placeholder="Enter Minimum 6 digit password" name="password" aria-label="password">
                                <label for="password">Password</label>
                            </div>
                        </div>
                    </div>
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
