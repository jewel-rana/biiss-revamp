@extends('master.app')
@section('owncss')
    <link rel="stylesheet" href="{{asset('/date/jquery.datetimepicker.css') }}" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <link rel="stylesheet" href="{{asset('/css/select2.min.css') }}" />


    <style>
        .modal-dialog {
            width: 65%;
            margin: 0 auto;

        }


    </style>

@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Book or Journal or Seminar Return</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('book_return.index') }}"> Back</a>
            </div>
        </div>
    </div>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="employee_basic_info">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        {!! Form::open(array('method'=>'POST', 'files' => true, 'runat'=>'server')) !!}

                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group form-float">
                                    <strong>Cursor Here before QR scene :</strong>
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon1"><i class="fa fa-qrcode" aria-hidden="true"></i></span>

                                        <input class="form-control" name="qrString" onChange="qrPopulateScan(this.value);" type="text"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="employee_basic_info">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">


                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Book Title <span style="color: red">*</span> :<span style="font-size: 14px">(Search by book,member)</span></strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    <?php// print_r($insertData['book_issue']); ?>
                                    <select class="form-control multi-select" name="book_issue_code" required>
                                        <option value="" selected disabled hidden>---Select Issue---</option>
                                        @foreach($insertData['book_issue'] as $key=>$employee)
                                            <option value="{{ $employee }}">{{ $employee }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>


                       <!-- <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Select Member <span style="color: red">*</span> :</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>

                                    <select class="form-control" name="user_id" required>
                                        <option value="" selected disabled hidden>Select Member</option>
                                    </select>


                                </div>
                            </div>
                        </div>-->




                        <!--<div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Issued Type <span style="color: red">*</span> :</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>

                                    <select class="form-control" name="type" required>

                                    </select>

                                </div>
                            </div>
                        </div>-->

                        <!--<div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>End Issue Date <span style="color: red">*</span>:</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    {!!  Form::text('end_issue_date', null, array('placeholder' => 'End issue date', 'id'=>'end_issue_datee', 'required' => 'required','class' => 'form-control','readonly' => 'true')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Return Date <span style="color: red">*</span>:</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    {!! Form::text('return_date', null, array('placeholder' => 'start_date', 'id'=>'datetimepicker_joine', 'required' => 'required','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>-->





                    </div>


                </div>
            </div>
        </div>
        <!--<div class="col-xs-12 col-sm-12 col-md-12">
            <button type="submit" class="btn btn-primary crud-submittt">Submit</button>
        </div>-->
    </div>


    <div class="modal fade" tabindex="-1" role="dialog" id="getCodeModal">
        <div class="modal-lg modal-dialog" role="document">
            <div class="modal-content">


                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="text-align: center"></h4>
                </div>

                <div class="modal-body">

                    <div id="printablediv" style="border-top: 1px solid #ddd;">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Member Name</th>
                                <th>Title</th>
                                <th>Image</th>
                                <th>Return Date</th>
                                <th>Today</th>
                                <th>Origin</th>
                                <th>Late</th>
                                <th>Fine</th>
                            </tr>
                            </thead>
                            <tbody id="invicetable">
                            </tbody>
                        </table>
                    </div>


                    <div id="create-item">

                      {!! Form::open(array('route' => 'book_return.store','method'=>'POST')) !!}
                        {!! Form::hidden('book_issue_code', null, array('placeholder' => 'book_issue_code', 'id'=>'book_issue_code', 'required' => 'required','class' => 'form-control','readonly' => 'true')) !!}
                        {!! Form::hidden('user_id', null, array('placeholder' => 'user_id', 'id'=>'user_id', 'required' => 'required','class' => 'form-control','readonly' => 'true')) !!}
                        {!! Form::hidden('end_issue_date', null, array('placeholder' => 'End issue date', 'id'=>'end_issue_date', 'required' => 'required','class' => 'form-control','readonly' => 'true')) !!}
                        {!! Form::hidden('return_date', null, array('placeholder' => 'start_date', 'id'=>'datetimepicker_join', 'required' => 'required','class' => 'form-control')) !!}
                        <button type="submit" class="btn btn-primary  crud-submit"  data-dismiss="modal" data-backdrop="false">Save changes</button>
                        <button type="button" class="btn btn-default" id="modalclose">Close</button>
                      {!! Form::close() !!}

                    </div>

                </div>
                <!--<div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>-->





            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->




@endsection



@section('ownjs')

    <script src="{{asset('/js/select22.min.js')}}"></script>
    <script type="text/javascript">
        $(".multi-select").select2();
    </script>

    <script src="{{asset('/date/jquery.datetimepicker.full.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $( "#datetimepicker_join" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#datetimepicker_confirmation" ).datepicker({ dateFormat: 'yy-mm-dd' });
    </script>

    <script type="text/javascript">

        $('#modalclose').click(function (e) {
            e.preventDefault();
            $("#getCodeModal").modal("hide");
            var url = "{{Request::root()}}/dashboard/book_return/create";
            window.location.href = url;
        });


        function qrPopulateScan(qr) {

            //e.preventDefault();
            //var stateId = $(this).val();
            var stateId = qr;



            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            if(stateId) {
                $.ajax({
                    url: '{{Request::root()}}/dashboard/myformQr/ajax/'+stateId,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                        console.log(data);

                        var today = new Date();
                        var dd = today.getDate();
                        var mm = today.getMonth()+1;
                        var yyyy = today.getFullYear();
                        var current_date=yyyy+'-'+mm+'-'+dd;

                        var return_last_date=data.cities.end_date;
                        var now = new Date();
                        var return_last_date_time = (new Date(return_last_date)).getTime();
                        var current_date_time = now.getTime();

                        //console.log(return_last_date_time);
                        //console.log(current_date_time);
                        var daysDiff=0
                        if(current_date_time>return_last_date_time){
                            var microSecondsDiff = Math.abs(return_last_date_time - current_date_time );
                            daysDiff = Math.floor(microSecondsDiff/(1000 * 60 * 60  * 24));
                        }


                        if(data.book.origin=='local'){
                            var fine_rate=10;
                            var fine_total=10*daysDiff;
                        }else{
                            var fine_rate=50;
                            var fine_total=50*daysDiff;
                        }

                        var bookurl='<img src="{{Request::root()}}/uploads/books/'+data.book.cover_photo+'" width="60" height="45">';

                        $("#getCodeModal").modal('show');

                        $('.modal-title').html('<span>Invoce of '+ data.cities.user_name +'</span>');
                        $('#invicetable').html('<tr>' +
                            '<td>'+ data.cities.user_name +'</td>' +
                            '<td>'+ data.book.title+'</td>' +
                            '<td>'+ bookurl +'</td>' +
                            '<td>'+ return_last_date +'</td>' +
                            '<td>'+ current_date +'</td>' +
                            '<td>'+ data.book.origin+'</td>' +
                            '<td>'+daysDiff+'</td>' +
                            '<td>'+fine_total+'</td>' +
                            '</tr>');


                        $('#book_issue_code').val(data.cities.book_issue_code);
                        $('#user_id').val(data.cities.user_id);
                        $('#end_issue_date').val(data.cities.end_date);
                        $('#datetimepicker_join').val(current_date);


                    }
                });


            }else{
                $('select[name="user_id"]').empty();
                $('select[name="qrString"]').empty();
            }

            //$(this).empty();

        };

    </script>



    <script type="text/javascript">
        //$('select[name="book_issue_code"]').off();
        $('#modalclose').click(function (e) {
            e.preventDefault();
            $("#getCodeModal").modal("hide");
            var url = "{{Request::root()}}/dashboard/book_return/create";
            window.location.href = url;
        });


        $('select[name="book_issue_code"]').on('change', function() {

            //e.preventDefault();
            var stateId = $(this).val();


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            if(stateId) {
                $.ajax({
                    url: '{{Request::root()}}/dashboard/myform/ajax/'+stateId,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                        console.log(data);

                        var today = new Date();
                        var dd = today.getDate();
                        var mm = today.getMonth()+1;
                        var yyyy = today.getFullYear();
                        var current_date=yyyy+'-'+mm+'-'+dd;

                        var return_last_date=data.cities.end_date;
                        var now = new Date();
                        var return_last_date_time = (new Date(return_last_date)).getTime();
                        var current_date_time = now.getTime();

                        //console.log(return_last_date_time);
                        //console.log(current_date_time);
                        var daysDiff=0
                        if(current_date_time>return_last_date_time){
                            var microSecondsDiff = Math.abs(return_last_date_time - current_date_time );
                            daysDiff = Math.floor(microSecondsDiff/(1000 * 60 * 60  * 24));
                        }


                        if(data.book.origin=='local'){
                            var fine_rate=10;
                            var fine_total=10*daysDiff;
                        }else{
                            var fine_rate=50;
                            var fine_total=50*daysDiff;
                        }

                        var bookurl='<img src="{{Request::root()}}/uploads/books/'+data.book.cover_photo+'" width="60" height="45">';

                        $("#getCodeModal").modal('show');

                        $('.modal-title').html('<span>Invoice of '+ data.cities.user_name +'</span>');
                        $('#invicetable').html('<tr>' +
                            '<td>'+ data.cities.user_name +'</td>' +
                            '<td>'+ data.book.title+'</td>' +
                            '<td>'+ bookurl +'</td>' +
                            '<td>'+ return_last_date +'</td>' +
                            '<td>'+ current_date +'</td>' +
                            '<td>'+ data.book.origin+'</td>' +
                            '<td>'+daysDiff+'</td>' +
                            '<td>'+fine_total+'</td>' +
                            '</tr>');


                        $('#book_issue_code').val(data.cities.book_issue_code);
                        $('#user_id').val(data.cities.user_id);
                        $('#end_issue_date').val(data.cities.end_date);
                        $('#datetimepicker_join').val(current_date);


                    }
                });


            }else{
                $('select[name="user_id"]').empty();
            }

            //$(this).empty();

        });



    </script>



<script type="text/javascript">
       $('.crud-submit').on('click', function(e) {

            e.preventDefault();

            var form_action = $("#create-item").find("form").attr("action");
            var book_issue_code = $("#create-item").find("input[name='book_issue_code']").val();
            var user_id = $("#create-item").find("input[name='user_id']").val();
            var end_issue_date = $("#create-item").find("input[name='end_issue_date']").val();
            var return_date = $("#create-item").find("input[name='return_date']").val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                    url: form_action,
                    type: "POST",
                    dataType: "json",
                    data:{book_issue_code:book_issue_code, user_id:user_id, end_issue_date:end_issue_date,return_date:return_date},
                    success:function(data) {

                        console.log(data);

                        var today = new Date();
                        var dd = today.getDate();
                        var mm = today.getMonth()+1;
                        var yyyy = today.getFullYear();
                        var current_date=yyyy+'-'+mm+'-'+dd;

                        var return_last_date=data.cities.end_date;
                        var now = new Date();
                        var return_last_date_time = (new Date(return_last_date)).getTime();
                        var current_date_time = now.getTime();
                        var daysDiff=0
                        if(current_date_time>return_last_date_time){
                            var microSecondsDiff = Math.abs(return_last_date_time - current_date_time );
                            daysDiff = Math.floor(microSecondsDiff/(1000 * 60 * 60  * 24));
                        }




                        if(data.book.origin=='local'){
                            var fine_rate=10;
                            var fine_total=10*daysDiff;
                        }else{
                            var fine_rate=50;
                            var fine_total=50*daysDiff;
                        }

                        var bookurl='<img src="{{Request::root()}}/uploads/books/'+data.book.cover_photo+'" width="60" height="45">';


                        $('#invicetable').html('<tr>' +
                            '<td>'+ data.cities.user_name +'</td>' +
                            '<td>'+ data.book.title+'</td>' +
                            '<td>'+ bookurl +'</td>' +
                            '<td>'+ return_last_date +'</td>' +
                            '<td>'+ current_date +'</td>' +
                            '<td>'+ data.book.origin+'</td>' +
                            '<td>'+daysDiff+'</td>' +
                            '<td>'+fine_total+'</td>' +
                            '</tr>');





                        var divElements = document.getElementById('printablediv').innerHTML;
                        var oldPage = document.body.innerHTML;
                        document.body.innerHTML =
                            "<html><head><title>Books Info For Print</title></head><body><div style='text-align:center;border-bottom:1px solid #ddd;'><h2>Bangladesh Institute of International and Strategic Studies (BIISS)</h2><h4>Books Info For Print</h4></div>" +
                            divElements + "</body>";
                        window.print();
                        document.body.innerHTML = oldPage;
                        var url = "{{Request::root()}}/dashboard/book_return";
                        window.location.href = url;

                    }
             });
       });
 </script>





@endsection