@extends('admin.layouts.master')
@section('content')
    
<div class="container-fluid p-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header ">
                    <form method="GET" class="d-flex justify-content-between align-items-center" action="{{ route('userfeedback.index') }}" id="dateFilterForm">
                             <h5>User Feedback List</h5>
                            <input type="date" class="form-control w-25" id="date" name="date" value="{{ request('date') }}" onchange="document.getElementById('dateFilterForm').submit();">
                    </form>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Submission ID</th>
                                <th>Submitted At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userfeedbacks as $userfeedback)
                                <tr>
                                    <td class="align-middle">{{$loop->iteration}}</td>
                                    <td class="align-middle">{{ $userfeedback->submission_id }}</td>
                                    <td class="align-middle">{{ $userfeedback->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <a href="{{ route('userfeedbacks.view', $userfeedback->submission_id) }}" class="btn btn-primary btn-sm">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection