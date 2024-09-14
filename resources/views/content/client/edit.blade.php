@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Client Management')

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
        <!-- Client Information -->
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Edit Client Information</h5>
            </div>

            <div class="card-body">
                <form id="editClientForm" method="POST" action="{{ route('client-update', $editClient->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row gx-5 mb-5">
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="client_name" placeholder="Enter Client Name"
                                    name="client_name" aria-label="Client Name" value="{{ $editClient->client_name ?? '' }}">
                                <label for="client_name">Client Name</label>
                            </div>
                        </div>
                
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="sort_desc" placeholder="Enter Short Description"
                                    name="sort_desc" aria-label="Short Description" value="{{ $editClient->short_description ?? '' }}">
                                <label for="sort_descn">Short Description</label>
                            </div>
                        </div>

                        <div class="row gx-5 mb-5 mt-3"></div>
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <input type="file" class="form-control" id="client_image" name="client_image">
                                <label for="client_image">Client Image</label>
                                @if(!empty($editClient->client_image))
                                    <div class="mt-2">
                                        <img src="{{ asset('uploads/clients/' . $editClient->client_image) }}" alt="Client Image" style="width:100px; height:auto;">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <select class="form-select" id="status" name="status" aria-label="Client Status">
                                    <option value="1" {{ $editClient->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $editClient->status == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                                <label for="status">Status</label>
                            </div>
                        </div>
                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" id="submitForm" class="btn btn-primary waves-effect waves-light">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#editClientForm').on('submit', function(event) {
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
                            text: 'Client updated successfully!'
                        }).then(function() {
                            window.location.href = "{{ route('client-list') }}";
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
