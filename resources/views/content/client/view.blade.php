@extends('layouts/contentNavbarLayout')

@section('title', 'Client Information')

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
    <!-- Client Information -->
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h3>Client Information</h3>

                <div class="row g-3 mt-3">
                    <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold;">Client Name</label>
                        <p class="form-control-plaintext">{{ $viewClient->client_name ?? '' }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold;">Client Image</label>
                        <p class="form-control-plaintext">
                            @if(!empty($viewClient->client_image))
                                <img src="{{ asset('uploads/clients/'.$viewClient->client_image) }}" alt="Client Image" style="width:100px; height:auto;">
                            @else
                                No image available
                            @endif
                        </p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold;">Status</label>
                        <p>
                        <div
                            class="badge {{ $viewClient->status == 1 ? 'bg-label-success' : 'bg-label-danger' }}">
                            {{ $viewClient->status == 1 ? 'Active' : 'Inactive' }}
                        </div>
                        </p>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold;">Created At</label>
                        <p class="form-control-plaintext">{{ $viewClient->created_at }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold;">Updated At</label>
                        <p class="form-control-plaintext">{{ $viewClient->updated_at }}</p>
                    </div>
                    <div class="col-12">
                        <a href="{{ route('client-list') }}" class="btn btn-primary">Back to List</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
