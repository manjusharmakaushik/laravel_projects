@extends('layouts/contentNavbarLayout')

@section('title', 'Testimonial Information')

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
    <!-- Testimonial Information -->
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h3>Testimonial Information</h3>

                <div class="row g-3 mt-3">
                    <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold;">Testimonial Name</label>
                        <p class="form-control-plaintext">{{ $viewTestimonial->testimonial_name ?? '' }}</p>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label" style="font-weight: bold;">Short Description</label>
                        <p class="form-control-plaintext">{{ $viewTestimonial->sort_desc ?? '' }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold;">Testimonial Image</label>
                        <p class="form-control-plaintext">
                            @if(!empty($viewTestimonial->testimonial_image))
                                <img src="{{ asset('testimonial/'.$viewTestimonial->testimonial_image) }}" alt="Testimonial Image" style="width:100px; height:auto;">
                            @else
                                No image available
                            @endif
                        </p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold;">Status</label>
                        <p>
                        <div
                            class="badge {{ $viewTestimonial->status == 1 ? 'bg-label-success' : 'bg-label-danger' }}">
                            {{ $viewTestimonial->status == 1 ? 'Active' : 'Inactive' }}
                        </div>
                        </p>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold;">Created At</label>
                        <p class="form-control-plaintext">{{ $viewTestimonial->created_at }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold;">Updated At</label>
                        <p class="form-control-plaintext">{{ $viewTestimonial->updated_at }}</p>
                    </div>
                    <div class="col-12">
                        <a href="{{ route('testimonial-list') }}" class="btn btn-primary">Back to List</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
