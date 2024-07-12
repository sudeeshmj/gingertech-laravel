@extends('admin.layouts.master')
@section('content')

<div class="container-fluid p-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Feedback Submission Details</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sl. No</th>
                                <th>Question</th>
                                <th>Answer</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($feedbacks as $index => $feedback)
                                <tr>
                                    <td>{{ $loop->iteration}}</td>
                                    <td>{{ $feedback->question->title }}</td>
                                    <td>{{ $feedback->answer }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ route('userfeedback.index') }}" class="btn btn-secondary">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
