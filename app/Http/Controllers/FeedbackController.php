<?php

namespace App\Http\Controllers;

use App\Models\UserFeedback;
use Illuminate\Http\Request;
use Carbon\Carbon;
class FeedbackController extends Controller
{
    
    public function index(Request $request)
    {
        $query = UserFeedback::select('submission_id', 'created_at')
                ->groupBy('submission_id', 'created_at')
                ->orderBy('created_at', 'desc');

  
        if ($request->has('date')) {
            $date = Carbon::parse($request->date)->startOfDay();
            $query->whereDate('created_at', $date);
        }

        $userfeedbacks = $query->get();

    return view('admin.feedbacks.list', compact('userfeedbacks'));
    }


    public function show($id)
    {
        $feedbacks = UserFeedback::with('question')->where('submission_id', $id)->get();

        if ($feedbacks->isEmpty()) {
            return redirect()->route('userfeedback.index')->with('error', 'User Feedback not found.');
        }

        return view('admin.feedbacks.view',compact('feedbacks'));
    }


}
