<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="{{asset('js/scripts.js')}}"></script>
        <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
        <link href="{{asset('css/styles.css')}}" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    </head>
<body>
<div class="container-fluid p-4">
    <div class="row">
        <div class="col-md-12">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h5>User Feedback</h5>
                </div>
                <div class="card-body">
                    @if (session()->has('message'))
                    <script>
                        toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        positionClass: 'toast-bottom-right' 
                    }; 
                    toastr.success("{{session()->get('message')}}")</script>
                    @endif
                    @if (session()->has('error'))
                    <script> 
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        positionClass: 'toast-bottom-right' 
                    }; toastr.error("{{session()->get('error')}}")</script>
                    @endif
                    <form method="post" action="{{ route('userfeedabck.submit') }}">
                        @csrf
                        @foreach($questions as $question)

                            <div class="mb-3">
                                <label for="question_{{ $question->id }}" class="form-label">{{ $question->title }}</label>
                                @if($question->type == 'text')
                                    <input type="text" class="form-control" id="question_{{ $question->id }}" name="answers[{{ $question->id }}]" value="{{ old('answers.' . $question->id) }}" required>
                                @elseif($question->type == 'date')
                                    <input type="date" class="form-control" id="question_{{ $question->id }}" name="answers[{{ $question->id }}]" value="{{ old('answers.' . $question->id) }}" required>
                                @elseif($question->type == 'email')
                                    <input type="email" class="form-control" id="question_{{ $question->id }}" name="answers[{{ $question->id }}]" value="{{ old('answers.' . $question->id) }}" required>
                                @elseif($question->type == 'number')
                                    <input type="number" class="form-control" id="question_{{ $question->id }}" name="answers[{{ $question->id }}]" value="{{ old('answers.' . $question->id) }}" required>
                                @elseif($question->type == 'select-box')
                                    <select class="form-select" id="question_{{ $question->id }}" name="answers[{{ $question->id }}]" required>
                                        <option value="">--Select--</option>
                                        @foreach($question->options as $option)
                                            <option value="{{ $option->option_value }}" {{ old('answers.' . $question->id) == $option->option_value ? 'selected' : '' }}>{{ $option->option_value }}</option>
                                        @endforeach
                                    </select>
                                @elseif($question->type == 'radio-button')
                                    @foreach($question->options as $option)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" id="option_{{ $option->id }}" value="{{ $option->option_value }}" {{ old('answers.' . $question->id) == $option->option_value ? 'checked' : '' }} required>
                                            <label class="form-check-label" for="option_{{ $option->id }}">{{ $option->option_value }}</label>
                                        </div>
                                    @endforeach
                                @endif
                                @error('answers.' . $question->id)
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        @endforeach
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>

</html>