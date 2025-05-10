@extends('layouts.app')
@section('owncss')
    <link rel="stylesheet" href="{{asset('/date/jquery.datetimepicker.css') }}" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <link rel="stylesheet" href="{{asset('/css/select2.min.css') }}" />

@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Book or Journal Return</h2>
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
    {!! Form::open(array('route' => 'book_return.store','method'=>'POST', 'files' => true, 'runat'=>'server')) !!}

    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="employee_basic_info">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">


                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Select Issue <span style="color: red">*</span> :<span style="font-size: 12px">(Seach by book,member)</span></strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    <select class="form-control multi-select" name="book_issue_code" required>
                                        <option value="" selected disabled hidden>---Select Issue---</option>
                                        @foreach($insertData['book_issue'] as $key=>$employee)
                                            <option value="{{ $employee }}">{{ $employee }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Select Member <span style="color: red">*</span> :</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>

                                    <select class="form-control" name="user_id" required>
                                        <option value="" selected disabled hidden>Select Member</option>
                                    </select>


                                </div>
                            </div>
                        </div>




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

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>End Issue Date <span style="color: red">*</span>:</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    {!! Form::text('end_issue_date', null, array('placeholder' => 'End issue date', 'id'=>'end_issue_date', 'required' => 'required','class' => 'form-control','readonly' => 'true')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Return Date <span style="color: red">*</span>:</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    {!! Form::text('return_date', null, array('placeholder' => 'start_date', 'id'=>'datetimepicker_join', 'required' => 'required','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>





                    </div>


                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="getCodeModal">
        <div class="modal-lg modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="text-align: center"></h4>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>User Name</th>
                            <th>Book id</th>
                            <th>Book image</th>
                            <th>End Issue date</th>
                            <th>Return date</th>
                            <th>Origin</th>
                            <th>late</th>
                            <th>Fine</th>
                        </tr>
                        </thead>
                        <tbody id="invicetable">



                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    {!! Form::close() !!}


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

        $('select[name="book_issue_code"]').on('change', function() {
            var stateId = $(this).val();
            //alert(stateId);
            if(stateId) {
                $.ajax({
                    url: '{{Request::root()}}/dashboard/myform/ajax/'+stateId,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                        var today = new Date();
                        var dd = today.getDate();
                        var mm = today.getMonth()+1;
                        var yyyy = today.getFullYear();
                        var current_date=yyyy+'-'+mm+'-'+dd;

                        var return_last_date=data.cities.end_date;
                        var now = new Date();
                        var return_last_date_time = (new Date(return_last_date)).getTime();
                        var current_date_time = now.getTime();
                        var microSecondsDiff = Math.abs(return_last_date_time - current_date_time );
                        var daysDiff = Math.floor(microSecondsDiff/(1000 * 60 * 60  * 24));

                        console.log(daysDiff);

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
                        console.log(data.book.cover_photo);
                        $('select[name="user_id"]').empty();
                        $('select[name="user_id"]').append('<option value="'+ data.cities.user_id +'">'+ data.cities.user_name +'</option>');

                        //$('select[name="type"]').empty();
                       // $('select[name="type"]').append('<option value="'+ data.type +'">'+ data.type +'</option>');


                        $('#end_issue_date').val(data.cities.end_date);

                        /*$('select[name="city"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="city"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                       */

                    }
                });
            }else{
                $('select[name="user_id"]').empty();
            }
        });

</script>






@endsection