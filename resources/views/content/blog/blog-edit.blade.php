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
                <h5 class="card-title mb-0">Edit Blog Information</h5>
            </div>

            <div class="card-body">
                <form id="editblogForm" action="{{ route('blog-update', $editBlog->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Service Name -->
                    <div class="row gx-5 mb-5">
                        <div class="col">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" placeholder="Enter Blog Name" name="name" aria-label="Full Name"
                                    value="{{ old('name', $editBlog->heading ?? '') }}">
                                <label for="name">Blog Name</label>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Image Upload and Preview -->
                        <div class="col-sm-6">
                            <div class="form-floating form-floating-outline">
                                <input type="file" name="image" id="image"
                                    class="form-control @error('image') is-invalid @enderror" aria-label="Choose Image">
                                <label for="image">Image</label>

                                <!-- Image preview container -->
                                <div class="mt-3">
                                    <!-- Display the current image if it exists -->
                                    @if ($editBlog->image && file_exists(public_path($editBlog->image)))
                                        <!-- Display the current image if it exists -->
                                        <img src="{{ asset($editBlog->image) }}" id="currentImage" alt="Current Image" style="width: 150px; height: auto;">
                                    @else
                                        <!-- Display the default "no image" placeholder -->
                                        <img src="{{ asset('assets/def-image/no-image.png') }}" id="currentImage"  class=" waves-light" alt="No Image Available" style="width: 100px; height: auto;border:2px solid grey;">
                                    @endif
                                    <!-- Preview the new image -->
                                    <img id="imagePreview" src="" alt="Image preview"
                                        style="display: none; width: 150px; height: auto; object-fit: cover;">
                                </div>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Short Description -->
                    <div class="row gx-5 mb-5">
                        <div class="col-sm-6">
                        <div class="form-floating form-floating-outline">
                            <textarea id="short_desc" name="short_desc" class="form-control @error('short_desc') is-invalid @enderror"
                                placeholder="Short Description" aria-label="Short Description">{{ old('short_desc', $editBlog->short_desc ?? '') }}</textarea>
                                <label for="short_desc">Short Description</label>
                           
                                @error('short_desc')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            </div>
                        </div>
                    </div>
                    <div class="editor-container">
                    <textarea name="description" id="editor" style="padding:100px">
                    {{ old('description', $editBlog->description ?? '') }}
        </textarea>
</div>
                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary my-6">Update</button>

               
                </form>

            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Function to clear previous validation messages
            function clearValidationErrors() {
                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').remove();
            }

            // Preview selected image before submission
            $('#image').on('change', function() {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        $('#imagePreview').attr('src', event.target.result).show();
                        $('#currentImage')
                            .hide(); // Hide the current image when a new image is selected
                    }
                    reader.readAsDataURL(file);
                } else {
                    $('#imagePreview').hide();
                    $('#currentImage').show(); // Show the current image if no new file is selected
                }
            });

            // Handle form submission with AJAX
            $('#editblogForm').on('submit', function(event) {
                event.preventDefault();

                clearValidationErrors(); // Clear previous validation messages

                var form = $(this);
                var url = form.attr('action');
                var formData = new FormData(this);

                var valid = true;

                var pattern = /^[a-zA-Z!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/? ]+$/;
                const name=$('#name').val().trim(); 
                if ($('#name').val().trim() === '') {
                    $('#name').addClass('is-invalid');
                    $('#name').after('<div class="invalid-feedback">Blog Name is required.</div>');
                    valid = false;
                }
                else if(!pattern.test(name) && name !=''){
                    $('#name').addClass('is-invalid');
                                    $('#name').after('<div class="invalid-feedback">only alphabets are required</div>');
                                    valid = false;
                }
                if ($('#image')[0].files.length === 0 && !$('#currentImage').attr('src')) {
                        $('#image').addClass('is-invalid');
                        $('#image').after('<div class="invalid-feedback">Image is required.</div>');
                        valid = false;
                    } else if ($('#image')[0].files.length > 0) {
                        const file = $('#image')[0].files[0];
                        const fileType = file.type;

                        if (fileType === 'image/gif') {
                            $('#image').addClass('is-invalid');
                            $('#image').after('<div class="invalid-feedback">GIF images are not allowed.</div>');
                            valid = false;
                        }
}


                if ($('#short_desc').val().trim() === '') {
                    $('#short_desc').addClass('is-invalid');
                    $('#short_desc').after('<div class="invalid-feedback">Short Description is required.</div>');
                    valid = false;
                }

                if (!valid) return;

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
                            text: 'Blog updated successfully!'
                        }).then(function() {
                            window.location.href = "{{ route('blog-list') }}";
                        });
                    },
                    error: function(response) {
                        let errors = response.responseJSON.errors;
                        let errorMessage = '';
                        for (let key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                errorMessage += errors[key][0] + '\n';
                                $('#' + key).addClass('is-invalid');
                                $('#' + key).after('<div class="invalid-feedback">' + errors[
                                    key][0] + '</div>');
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

<style>

   
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
