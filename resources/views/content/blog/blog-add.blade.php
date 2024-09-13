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
        <!-- Service Information -->
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Add Blog Information</h5>
            </div>
            <div class="card-body">
                <form id="blogForm" enctype="multipart/form-data" action="{{ route('blog-store') }}" method="POST">
                    @csrf
                    <div class="row gx-5 mb-5">
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="name" placeholder="Enter Blog Name"
                                    name="name" aria-label="Full Name">
                                <label for="name">Blog Name</label>
                            </div>
                        </div>
                    
                    </div>
                 
                    <div class="editor-container">
                    <div class="row gx-5 mb-5">
                        <div class="col-sm-12">
                        <textarea name="description" id="editor" style="height:500px" placeholder="Add Description" placeholder="Short Description"
                        aria-label="Description" aria-describedby="basic-icon-default-message2">

                        </textarea>
                        </div>
                    </div>
</div>
                    <div class="row gx-5 mb-5">
                        <div class="col-sm-6">
                            <textarea id="short_desc" name="short_desc" class="form-control" placeholder="Short Description"
                                aria-label="Short Description" aria-describedby="basic-icon-default-message2"></textarea>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-floating form-floating-outline">
                                <input type="file" name="image" placeholder="Choose image" aria-label="Choose Image"
                                    id="image" class="form-control">
                                <label for="image">Image</label>
                                <!-- Image preview container -->
                                <div class="mt-3">
                                    <img id="imagePreview" src="#" alt="Image preview"
                                        style="display: none; width: 50%; max-height: 100px; object-fit: cover;">
                                </div>
                            </div>
                        </div>
                    </div>
                   
            </div>

          
            <div class="text-end my-5 mx-5">
                <button type="submit" id="submitForm" class="btn btn-primary waves-effect waves-light">Save</button>
            </div>


            <script>
        ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>
            </form>
           

        </div>
    </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#blogForm').on('submit', function(e) {
                e.preventDefault();

                // Clear previous error styles
                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                var formData = new FormData(this);

                var valid = true;

                // Client-side validation
                if ($('#name').val().trim() === '') {
                    $('#name').addClass('is-invalid');
                    $('#name').after('<div class="invalid-feedback">Blog Name is required.</div>');
                    valid = false;
                }

                if ($('#image')[0].files.length === 0) {
                    $('#image').addClass('is-invalid');
                    $('#image').after('<div class="invalid-feedback">Image is required.</div>');
                    valid = false;
                }

                if ($('#short_desc').val().trim() === '') {
                    $('#short_desc').addClass('is-invalid');
                    $('#short_desc').after('<div class="invalid-feedback">Short Description is required.</div>');
                    valid = false;
                }
                if ($('#editor').val().trim() === '') {
                    $('#editor').addClass('is-invalid');
                    $('#editor').after('<div class="invalid-feedback"> Description is required.</div>');
                    valid = false;
                }
                if (!valid) return;

                $.ajax({
                    url: "{{ route('blog-store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Blog added successfully!'
                        }).then(function() {
                            window.location.href = "{{ route('blog-list') }}";
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: 'Error!',
                            text: xhr.responseJSON.message || 'An error occurred.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            // Handle image preview
            $('#image').on('change', function(event) {
                var file = event.target.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagePreview').attr('src', e.target.result).show();
                    };
                    reader.readAsDataURL(file);
                } else {
                    $('#imagePreview').attr('src', '#').hide();
                }
            });
        });


        
    </script>




    <style>
        .is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 0.875em;
        }
       
   

   
        .editor-container {
    width: 100%; 
    max-width: 1200px; 
    margin-right:10px;
    padding: 20px; 
}


.ck-editor__editable {
    min-height: 400px; 
    border: 1px solid #ddd; 
    border-radius: 4px; 
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); 
    background-color: #f9f9f9; 
    font-family: Arial, sans-serif; 
    font-size: 16px; 
    line-height: 1.6; 
}


.ck-toolbar {
    border-bottom: 1px solid #ddd; 
    border-radius: 4px 4px 0 0; 
    background-color: #fff; 
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); 
}


.ck-toolbar__items {
    display: flex;
    align-items: center;
}

.ck-button {
    border: none;
    border-radius: 4px;
    padding: 5px;
    margin: 0 2px;
    background-color: #e0e0e0; 
    transition: background-color 0.3s ease; 
}

.ck-button:hover {
    background-color: #d0d0d0; 
}


.ck-placeholder {
    color: #aaa; 
  
}




    </style>
@endsection
