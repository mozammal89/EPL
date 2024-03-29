@extends('layouts.app-layout')
@section('title','Home')
@section('content-title','GMEBD')
@push('breadcrumb')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css" />
<style>
div.dataTables_wrapper div.dataTables_filter input
{
    width: 700px;
    background-color: #b1d5f5;
    height: 30px;
    padding-left: 10px;
}

</style>
@endpush

@section('page-content')
<div class="col-md-12">
    <div class="row">
        <div class="col-md-12">
            @if ($message = Session::get('success'))
                <div class="alert alert-success "id="success-alert">
                    <p>{{ $message }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
<div class="card">
    <form action="{{Route('spo.password')}}" method="POST">
        @csrf
        <div class="card-header">
        Dealer Password Set
        </div>
        <div class="card-boy">
            <div class="container">
                <div class="row">
                    <div class="col-md-5">
                        <div class="row" style="margin-top:30px;">
                            <div class="col-md-12">
                                <label>Select Employee CODE*</label> 
                                <select class="form-control selectpicker" data-show-subtext="true" data-live-search="true"  name="emp_id"  id="dealer" required>
                                <option value="">Select Employee CODE</option>
                                @foreach($employees as $employee)
                                <option value="{{$employee->id}}">{{$employee->emp_code}}</option>
                                @endforeach
                            </select>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Employee Mail</label>
                                    <input class="form-control" id="dlno"  name="emp_mail" value="" type="email" />
                                </div>
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input class="form-control" id="dlno"  name="emp_password" value="" type="password" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                             <label for="">Employeee Name</label>
                            <input class="form-control"  id="emp_name"  name="emp_name" value="" type="text" Readonly/>
                        </div>
                        <div class="form-group">
                             <label for="">Employeee Designation</label>
                            <input class="form-control"  id="emp_des"  name="emp_des" value="" type="text" Readonly/>
                            <input class="form-control"  id="emp_desid"  name="emp_desid" value="" type="hidden" Readonly/>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <div id="dlname">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div id="dlcode">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
            <div class="text-center m-t-20" style="margin-bottom: 10%;">
                <button class="btn btn-primary submit-btn" type="submit" id="dgbtn">Set Password</button>
            </div>
            </div>
        </div>
    </form>
</div>
@endsection
@push('end_js')
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/i18n/defaults-*.min.js"></script>
<script>

$(document).ready(function(){
    $('select[name="emp_id"]').on('change',function(){
        var empid = $(this).val();
        
        // console.log(empid);
        if(empid){
            $.ajax({
                url: '/emp/name/get/'+empid,
                type:"GET",
                dataType:'json',
                success: function(date){
                    console.log(date);
                    var dlr_name='';
                    $('#dlname').empty();
                    $('#dlcode').empty();
                    $.each(date,function( index, value ){
                        $('#dlname').append("<p id='dinfo" + index + "'> Dealer Name: " + value.d_s_name+ "</p>");

                        $('#dlcode').append("<p id='dinfo" + index + "'> Dealer Code: " + value.dlr_code+ "</p>");

                        document.getElementById("emp_name").value = value.emp_name;
                        document.getElementById("emp_des").value = value.designation_title;
                        document.getElementById("emp_desid").value = value.emp_designation_id;
                        // dlr_name=dlr_name+" "+value.d_s_name;
                            // console.log(value.d_s_name);
                    });
                    // document.getElementById("emp_name").value= dlr_name;
                    // var empname = date[0].emp_name;
                     
                    }
            });
        }
    });
});
$(document).ready (function(){
            $("#success-alert").fadeTo(7000, 7000).slideUp(1000);
 });
</script>

@endpush