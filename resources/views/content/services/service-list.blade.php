@extends('layouts/contentNavbarLayout')

@section('title', 'Service')

@section('vendor-style')
    <style>
        .badge {
            cursor: pointer;
        }
    </style>
    <!-- DataTables CSS from CDN -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endsection
@section('vendor-script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
@endsection

@section('page-script')

    <script type="text/javascript">
        $(document).ready(function() {
            $('#serviceDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('service-list') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'service_name',
                        name: 'service_name'
                    },
                    {
                        data: 'sort_desc',
                        name: 'sort_desc'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        render: function(data, type, row) {

                            var imageUrl = data;

                            return `<img src="${imageUrl}" alt="Image" class="mt-3" style="width:130px; height:80px;">`;
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, row) {
                            var statusClass = data === 1 ? 'bg-label-success' : 'bg-label-danger';
                            var statusText = data === 1 ? 'Active' : 'Inactive';
                            return `<div class="badge ${statusClass}" data-id="${row.id}" id="status-${row.id}">${statusText}</div>`;
                        }
                    },


                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                dom: '<"top"lf>rt<"bottom"ip><"clear">',
                autoWidth: false,
                initComplete: function() {

                    $(".dataTables_filter").prepend(
                        '<button class="btn btn-primary mr-3" id="addService">Add Service</button>'
                    );
                    $('#addService').on('click', function() {
                        window.location.href =
                            '{{ route('service-create') }}';
                    });
                }
            });

            //status
            $(document).on('click', '.badge', function() {
                var $this = $(this);
                var serviceId = $this.data('id');
                var currentStatus = $this.text().trim() === 'Active' ? 1 : 0;
                var newStatus = currentStatus === 1 ? 0 : 1;

                $.ajax({
                    url: '/service-status/' + serviceId,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: newStatus
                    },
                    success: function(response) {
                        Swal.fire(
                            'Updated!',
                            'Service status has been updated.',
                            'success'
                        );


                        var newStatusText = newStatus === 1 ? 'Active' : 'Inactive';
                        var newStatusClass = newStatus === 1 ? 'bg-label-success' :
                            'bg-label-danger';

                        $this.text(newStatusText)
                            .removeClass('bg-label-success bg-label-danger')
                            .addClass(newStatusClass);
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'Failed to update service status.',
                            'error'
                        );
                        console.error(xhr.responseText);
                    }
                });
            });
        });

        function deleteCategory(serviceId) {

            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: '/service-delete/' + serviceId,
                        type: 'GET',
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                'Your service has been deleted.',
                                'success'
                            ).then(() => {

                                $('#serviceDataTable').DataTable().ajax
                                    .reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                'Failed to delete service.',
                                'error'
                            );
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        }
    </script>


@endsection

@section('content')

    <table id="serviceDataTable" class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Image</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>

@endsection
