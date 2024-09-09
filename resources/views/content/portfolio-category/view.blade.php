@extends('layouts/contentNavbarLayout')

@section('title', 'Portfolio category')

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
    {{-- {{ dump($viewPortfolioCategory) }} --}}
    <!-- User Information -->
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h3>Portfolio Category Information</h3>

                <div class="row g-3 mt-3">
                    <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold;">Category Name</label>
                        <p class="form-control-plaintext">{{ $viewPortfolioCategory->category_name ?? '' }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold;">Category Image</label>
                        <p class="form-control-plaintext">{{ $viewPortfolioCategory->category_image ?? '' }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold;">Status</label>
                        <p>
                        <div
                            class="badge {{ $viewPortfolioCategory->status == 1 ? 'bg-label-success' : 'bg-label-danger' }}">
                            {{ $viewPortfolioCategory->status == 1 ? 'Active' : 'Inactive' }}
                        </div>
                        </p>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold;">Created At</label>
                        <p class="form-control-plaintext">{{ $viewPortfolioCategory->created_at }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold;">Updated At</label>
                        <p class="form-control-plaintext">{{ $viewPortfolioCategory->updated_at }}</p>
                    </div>
                    <div class="col-12">
                        <a href="{{ route('user-list') }}" class="btn btn-primary">Back to List</a>

                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
