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
    {{-- {{ dump($viewPortfolio) }} --}}
    <!-- Portfolio Information -->
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h3>Portfolio Information</h3>
                <div class="row g-3 mt-3">
                    <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold;">Project name</label>
                        <p class="form-control-plaintext">{{ $viewPortfolio->project_name }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold;">Sort disc</label>
                        <p class="form-control-plaintext">{{ $viewPortfolio->sort_disc }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold;">Project complete year</label>
                        <p class="form-control-plaintext">{{ $viewPortfolio->project_complete_year }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold;">Technology</label>
                        <p class="form-control-plaintext">{{ $viewPortfolio->technology }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold;">Project image</label>
                        <p class="form-control-plaintext">{{ $viewPortfolio->project_image }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold;">Status</label>
                        <p>
                        <div class="badge {{ $viewPortfolio->status == 1 ? 'bg-label-success' : 'bg-label-danger' }}">
                            {{ $viewPortfolio->status == 1 ? 'Active' : 'Inactive' }}
                        </div>
                        </p>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold;">Created At</label>
                        <p class="form-control-plaintext">{{ $viewPortfolio->created_at }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold;">Updated At</label>
                        <p class="form-control-plaintext">{{ $viewPortfolio->updated_at }}</p>
                    </div>
                    <div class="col-12">
                        <a href="{{ route('portfolio-list') }}" class="btn btn-primary">Back to List</a>

                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
