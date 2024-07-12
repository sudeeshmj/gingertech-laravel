@extends('admin.layouts.master')
@section('content')

<div class="container-fluid p-4">
    <div class="row">
        <div class="col-md-12">
            <div id="response_message"></div>
            <div class="card">
                <div class="card-header">
                    <h5>
                        Questions
                        <a class="btn btn-sm btn-success float-end" href="{{route('questions.create')}}">Add New</a>
                    </h5>
                </div>
                <div class="card-body">
                    <div id="response_message"></div>
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
                    <table class="table table-sm table-striped table-bordered hover" id="myDataTable">
                        <thead>
                          <tr>
                            <th scope="col" style="width: 5%;" >#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Type</th>
                            <th scope="col">Status</th>
                            <th scope="col">Created on</th>
                            <th scope="col" style="width: 15%;" >Action</th>
                          </tr>
                        </thead>
                        <tbody id="tbody">
                           @if ($questions->isEmpty())
                               <tr><td colspan="6" class="text-center">No records found</td></tr>
                           @else
                               
                          
                         @foreach ($questions as $question)
                         <tr>
                            <td class="align-middle">{{$loop->iteration}}</td>
                            <td class="align-middle">{{$question->title}}</td>
                            <td class="align-middle">{{$question->type}}</td>
                            <td class="align-middle">{{$question->status}} </td>
                               
                            <td class="align-middle">{{$question->created_at->format('d-m-Y')}}</td>
                            <td class="align-middle">
                                <a class="btn btn-warning btn-sm" href="{{route('questions.edit' , encrypt($question->id))}}">Edit</a>
                                <button class="btn btn-danger btn-sm" id="deletebtn" value="{{$question->id}}" >Delete</button>

                            </td>
                          </tr>
                         @endforeach
                         @endif
                       
                        </tbody>
                      </table>
                    
                      
                </div>
            </div>
        </div>
    </div>
</div>
    @include('admin.questions.delete')
<script>
$(document).ready(function(){
toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-bottom-right' 
            };  

    $.ajaxSetup({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

$(document).on('click','#deletebtn',function(e){
            e.preventDefault();
            var comp_id = $(this).val();
            $('#delete_question_id').val(comp_id);
            $('#deleteModal').modal('show');
          
    });

//delete operation

        $(document).on('click','#delete_question_btn',function(e){
        e.preventDefault();
        var delete_company_id = $('#delete_question_id').val();   
        $.ajax({
               type:'post',
               url:"delete-question/"+delete_company_id,
               dataType:'json',
               success:function(response) {
               if(response.status == 404){ 
                    $("#deleteModal").modal('hide');
                    toastr.error(response.message)
                  
                    location.reload();
                }
                else{
                    $("#deleteModal").modal('hide');
                    toastr.success(response.message)
                  
                    location.reload();
               }
                
               },
               error:function(err) {
                 console.log(err);
               }
            });


    });
});

</script>
@endsection