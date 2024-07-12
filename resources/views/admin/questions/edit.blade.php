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
                    <h5>Edit Question</h5>
                </div>
                <div class="card-body">
                    <form method="post" id="questionform" action="{{ route('questions.update', encrypt($question->id)) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $question->title) }}">
                            @error('title')
                            <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-select" name="type" id="type" aria-label="Default select example">
                                <option value=''>--Select--</option>
                                <option value="text" {{ $question->type == 'text' ? 'selected' : '' }}>Text</option>
                                <option value="number" {{ $question->type == 'number' ? 'selected' : '' }}>Number</option>
                                <option value="date" {{ $question->type == 'date' ? 'selected' : '' }}>Date</option>
                                <option value="email" {{ $question->type == 'email' ? 'selected' : '' }}>Email</option>
                                <option value="select-box" {{ $question->type == 'select-box' ? 'selected' : '' }}>Select-Box</option>
                                <option value="radio-button" {{ $question->type == 'radio-button' ? 'selected' : '' }}>Radio-Button</option>
                            </select>
                            @error('type')
                            <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" name="status" id="status" aria-label="Default select example">
                                <option value=''>--Select--</option>
                                <option value="active" {{ $question->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $question->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                            <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div id="options-container" class="mb-3" style="{{ in_array($question->type, ['select-box', 'radio-button']) ? '' : 'display:none;' }}">
                            <label for="options" class="form-label">Options</label>
                            <div id="options-list">
                                @foreach($questionOptions as $option)
                                    <div class="input-group mb-2">
                                        <input type="text" name="options[]" class="form-control" value="{{ $option->option_value }}" placeholder="Option value" required>
                                        <button type="button" class="btn btn-danger btn-sm remove-option">Remove</button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-secondary btn-sm" id="add-option">Add Option</button>
                            @error('options')
                            <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary btn-sm">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $("#questionform").validate({
        rules: {
            title: {
                required: true,
                minlength: 2,
                maxlength: 191
            },
            type: {
                required: true
            },
            status: {
                required: true
            },
           
        },
        messages: {
            title: {
                required: "Please enter a title.",
                minlength: "Title must be at least 2 characters long.",
                maxlength: "Title cannot be more than 191 characters long."
            },
            type: {
                required: "Please select a type."
            },
            status: {
                required: "Please select a status."
            }
        }
    });

    $.validator.addMethod("checkOptions", function(value, element) {
        var type = $('#type').val();
        if (type === 'select-box' || type === 'radio-button') {
            var options = $("input[name='options[]']").map(function() {
                return $(this).val();
            }).get();
            return options.length > 0 && options.every(option => option.trim() !== "");
        }
        return true; // If type is not select-box or radio-button, the field is valid
    }, "Please add at least one option.");

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
});
</script>
@endsection
