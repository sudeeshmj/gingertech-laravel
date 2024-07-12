<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\UserFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuestionController extends Controller
{
   
    public function index()
    {

       $questions = Question::all();
       return view('admin.questions.list',compact('questions'));
    }

    public function create()
    {
        return view('admin.questions.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:2|max:191',
            'type' => 'required|string',
            'status' => 'required|string',
            'options' => 'required_if:type,select-box,radio-button|array',
            'options.*' => 'required|string'
        ]);

        // Save the question
        $question = new Question();
        $question->title = $request->title;
        $question->type = $request->type;
        $question->status = $request->status;
        $question->save();

        // Save the options if the type is select-box or radio-button
        if (in_array($request->type, ['select-box', 'radio-button']) && $request->has('options')) {
            foreach ($request->options as $option) {
                $questionOption = new QuestionOption();
                $questionOption->question_id = $question->id;
                $questionOption->option_value = $option;
                $questionOption->save();
            }
        }

        return redirect()->route('questions.index')->with('success', 'Question added successfully.');
    
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $question=  Question::find(decrypt($id)); 
        $questionOptions = QuestionOption::where('question_id', decrypt($id))->get();
        return view('admin.questions.edit',compact('question','questionOptions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|min:2|max:191',
            'type' => 'required|string',
            'status' => 'required|string',
            'options' => 'required_if:type,select-box,radio-button|array',
            'options.*' => 'required|string'
        ]);
    
        $question = Question::find(decrypt($id));
        if ($question) {
            $question->title = $request->title;
            $question->type = $request->type;
            $question->status = $request->status;
            $question->save();
    
            // Delete existing options and save new options
            QuestionOption::where('question_id', $question->id)->delete();
            if (in_array($request->type, ['select-box', 'radio-button']) && $request->has('options')) {
                foreach ($request->options as $option) {
                    $questionOption = new QuestionOption();
                    $questionOption->question_id = $question->id;
                    $questionOption->option_value = $option;
                    $questionOption->save();
                }
            }
    
            return redirect()->route('questions.index')->with('success', 'Question updated successfully.');
        } else {
            return redirect()->route('questions.index')->with('error', 'Question not found.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question =  Question::find($id); 
        if($question){
            QuestionOption::where('question_id', $id)->delete();
            $question->delete();
           return response()->json(['status'=>200,'message'=>'Question deleted Successfully']);
          }
          else{
             return response()->json(['status'=>404,'message'=>'Question Not Found']);
          }
    }

    public function showForm(){
        $questions = Question::with('options')->get();
        return view('questionform', compact('questions'));
    }
    public function userfeedbackSubmitForm (Request $request){

        $validatedData = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|string'
        ]);
        $submissionId = Str::uuid();
        foreach ($validatedData['answers'] as $questionId => $answer) {
            UserFeedback::create([
                'question_id' => $questionId,
                'answer' => $answer,
                'submission_id' => $submissionId
            ]);
        }

        return redirect()->back()->with('success', 'Your feedback have been submitted successfully.');

    }
}
