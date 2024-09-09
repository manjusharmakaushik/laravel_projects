@extends('layouts/contentNavbarLayout')

@section('title', 'Portfolio category')

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
            $('#service-categoryDatatabel').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('portfolio-cat-list') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'category_name',
                        name: 'category_name'
                    },
                    {
                        data: 'category_image',
                        name: 'category_image'
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
                    // Append the add button after the search input
                    $(".dataTables_filter").prepend(
                        '<button class="btn btn-primary mr-3" id="addUser">Add Portfolio Category</button>'
                    );
                    $('#addUser').on('click', function() {
                        window.location.href =
                            '{{ route('portfolio-cat-create') }}'; // Add your URL for user creation here
                    });
                }
            });

            //status
            $(document).on('click', '.badge', function() {
                var $this = $(this);
                var userId = $this.data('id');
                var currentStatus = $this.text().trim() === 'Active' ? 1 : 0;
                var newStatus = currentStatus === 1 ? 0 : 1;

                $.ajax({
                    url: '/portfolio-cat-status/' + userId,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: newStatus
                    },
                    success: function(response) {
                        Swal.fire(
                            'Updated!',
                            'User status has been updated.',
                            'success'
                        );

                        // Update badge based on new status
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
                            'Failed to update user status.',
                            'error'
                        );
                        console.error(xhr.responseText);
                    }
                });
            });
        });

        function deleteCategory(userId) {

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
                    // Send AJAX request to delete category
                    $.ajax({
                        url: '/portfolio-cat-delete/' + userId,
                        type: 'GET', // or 'POST' depending on your route definition
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                'Your user has been deleted.',
                                'success'
                            ).then(() => {
                                // Optionally, reload the table or update the UI
                                $('#service-categoryDatatabel').DataTable().ajax
                                    .reload(); // Reload DataTable
                            });
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                'Failed to delete user.',
                                'error'
                            );
                            console.error(xhr.responseText); // Log the error for debugging
                        }
                    });
                }
            });
        }
    </script>


@endsection

@section('content')


    <table id="service-categoryDatatabel" class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Category Name</th>
                <th>Category Image</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>

@endsection
