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
            $('#blogDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('blog-list') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'heading',
                        name: 'name',
                    },
                    {
                        data: 'short_desc',
                        name: 'short_desc',
                    },
                    {
    data: 'image',
    name: 'image',
    render: function(data, type, row) {
        var imageUrl = data;
        var defaultImageUrl = 'assets/def-image/no-image.png';

        // Return an image element with CSS fallback
        return `
            <div style="
                width: 130px; 
                height: 80px; 
                background-image: url('${defaultImageUrl}');
                background-size: cover; 
                background-position: center;
                background-repeat: no-repeat;
                text-align: center;
                line-height: 80px;
                color: #999;
            ">
                <img src="${imageUrl}" onerror="this.style.display='none'; this.parentElement.style.backgroundImage='url(${defaultImageUrl})';" 
                     alt="Image" style="width:130px; height:80px; display:block;"/>
            </div>`;
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
                        '<button class="btn btn-primary mr-3" id="addBlog">Add Blog</button>'
                    );
                    $('#addBlog').on('click', function() {
                        window.location.href =
                            '{{ route('blog-create') }}';
                    });
                }
            });

            //status
            $(document).on('click', '.badge', function() {
                var $this = $(this);
                var blogId = $this.data('id');
                var currentStatus = $this.text().trim() === 'Active' ? 1 : 0;
                var newStatus = currentStatus === 1 ? 0 : 1;

                $.ajax({
                    url: '/blog-status/' + blogId,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: newStatus
                    },
                    success: function(response) {
                        Swal.fire(
                            'Updated!',
                            'Blog status has been updated.',
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
                            'Failed to update blog status.',
                            'error'
                        );
                        console.error(xhr.responseText);
                    }
                });
            });
        });

        function deleteCategory(blogId) {

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
                        url: '/blog-delete/' + blogId,
                        type: 'GET',
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                'Your blog has been deleted.',
                                'success'
                            ).then(() => {

                                $('#blogDataTable').DataTable().ajax
                                    .reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                'Failed to delete blog.',
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

    <table id="blogDataTable" class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Heading</th>
                <th>Short Desc</th>
                <th>Image</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>

@endsection
