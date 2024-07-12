@extends('admin.layouts.master')
@section('content')
    
<style>
  
</style>
<div class="container-fluid p-4">
    <div class="row">
        <div class="col-md-12">
            <div id="response_message"></div>
            <div class="card">
                <div class="card-header">
                    <h5>Add New Question</h5>
                </div>
                <div class="card-body">
                    <form method="post"  id="qform" action="{{route('questions.store')}}">
                        @csrf
                        <div class="mb-3">
                          <label for="title" class="form-label">Title</label>
                          <input type="text" class="form-control" id="title" name="title" value="{{old('title')}}">
                          @error('title')
                          <span class="error-message">{{ $message }}</span>
                          @enderror
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-select" name="type" id="type"  >
                                <option selected value=''>--Select--</option>
                                <option value="text">Text</option>
                                <option value="number">Number</option>
                                <option value="date">Date</option>
                                <option value="email">Email</option>
                                <option value="select-box">Select-Box</option>
                                <option value="radio-button">Radio-Button</option>
                            </select>
                            @error('type')
                            <span class="error-message">{{ $message }}</span>
                            @enderror
                          </div>
                          <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" name="status" id="status" >
                                <option selected value=''>--Select--</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            @error('status')
                            <span class="error-message">{{ $message }}</span>
                            @enderror
                          </div>
                          @error('options')
                          <span class="error-message">{{ $message }}</span>
                          @enderror
                          <div id="options-container" class="mb-3" style="display:none;">
                            <label for="options" class="form-label">Options</label>
                            <div id="options-list"></div>
                            <button type="button" class="btn btn-secondary btn-sm" id="add-option">Add Option</button>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary btn-sm" >Submit</button>
                        </div>
                     
                      </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
  
    $("#qform").validate({
        rules: {
                title: {
                    required: true,
                    minlength: 2,
                    maxlength:191,
                },
                type: {
                    required: true,  
                },
                status: {
                    required: true,   
                },
               
               
            },
            messages: {
                title: {
                    required: "Please enter a title.",
                    minlength: "Title must be at least 2 characters long.",
                    maxlength: "Title cannot be more than 191 characters long."
                },
                type: {
                    required: "Please select a type.",
                   
                },
                status: {
                    required: "Please select a status.",
                  
                }           
            },



            });
        });

    // Show/Hide options based on type selection
    $('#type').change(function() {
        var selectedType = $(this).val();
        if (selectedType === 'select-box' || selectedType === 'radio-button') {
            $('#options-container').show();
        } else {
            $('#options-container').hide();
            $('#options-list').empty();
        }
    });

    // Add option fields dynamically
    $('#add-option').click(function() {
        $('#options-list').append(`
            <div class="input-group mb-2">
                <input type="text" name="options[]" class="form-control" placeholder="Option value" required>
                <button type="button" class="btn btn-danger btn-sm remove-option">Remove</button>
            </div>
        `);
    });

    // Remove option fields
    $(document).on('click', '.remove-option', function() {
        $(this).closest('.input-group').remove();
    });

</script>
@endsection