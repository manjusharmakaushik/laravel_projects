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
    <!-- {{-- {{ dump($viewService) }} --}} -->
    <!-- Service Information -->
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h3>Service Information</h3>
                <div class="row g-3 mt-3">
                    <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold;">Name</label>
                        <p class="form-control-plaintext">{{ $viewService->service_name }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold;">Description</label>
                        <p class="form-control-plaintext">{{ $viewService->sort_desc }}</p>
                    </div>
                  
                    <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold;">Status</label>
                        <p>
                        <div class="badge {{ $viewService->status == 1 ? 'bg-label-success' : 'bg-label-danger' }}">
                            {{ $viewService->status == 1 ? 'Active' : 'Inactive' }}
                        </div>
                        </p>
                    </div>
                    <div class="col-md-4">
                         <label class="form-label" style="font-weight: bold;">Service Image</label> 
                        <!-- Check if the image path is set and display the image -->
                        @if(isset($viewService->image) && !empty($viewService->image))
                            <img src="{{asset($viewService->image)}}" alt="Image" style="width:100px; height:auto;">
                        @else
                            <p>No image available</p>
                        @endif
                    </div>

                    <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold;">Created At</label>
                        <p class="form-control-plaintext">{{ $viewService->created_at }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold;">Updated At</label>
                        <p class="form-control-plaintext">{{ $viewService->updated_at }}</p>
                    </div>
                    <div class="col-12">
                        <a href="{{ route('service-list') }}" class="btn btn-primary">Back to List</a>

                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
