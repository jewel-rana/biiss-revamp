@extends('master.app')
@section('owncss')
    <link rel="stylesheet" href="{{asset('/date/jquery.datetimepicker.css') }}" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <link rel="stylesheet" href="{{asset('/css/select2.min.css') }}" />


@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Book /Journal/Seminar Issue</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('book_issue.index') }}"> Back</a>
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


    {!! Form::open(array('route' => 'book_issue.store','method'=>'POST', 'files' => true, 'runat'=>'server')) !!}

    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="employee_basic_info">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Book Title<span style="color: red">*</span> :</strong>


                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                    <select class="form-control multi-select" name="book_id" required>
                                        <option value="" selected disabled hidden>---Select book---</option>
                                        @foreach($insertData['book'] as  $SBook)
                                            <?php if(!empty($insertData['selectedbook'])) {
                                                ?>
                                                <option value="{{ $SBook['book_id'] }}" {{ ( $insertData['selectedbook']->id == $SBook['book_id'] ) ? 'selected' : '' }}>{{ $SBook['book_title'] }}</option>

                                            <?php
                                            }else{
                                                ?>
                                                <option value="{{ $SBook['book_id'] }}">{{ $SBook['book_title'] }}</option>

                                            <?php
                                                }?>

                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Copy Number </strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>

                                    {!! Form::select('copy_number', [], null, array('required' => 'required','class' => 'form-control multi-select')) !!}



                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Select Member <span style="color: red">*  </span><a href="{{Request::root()}}/dashboard/members/create">Create a new Member</a>  </strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>


                                    <select class="form-control multi-select" name="user_id" required>
                                        @foreach($insertData['member'] as $key=>$employee)
                                            <option value="{{ $key }}">{{ $employee }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Issue Type <span style="color: red">*</span> :</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                    {!! Form::select('type', ['temp'=>'temp', 'per'=>'per'], ['temp'=>'temp'], array('required' => 'required','class' => 'form-control show-tick')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Issue Date <span style="color: red">*</span>:</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                    {!! Form::text('start_date', null, array('placeholder' => 'issue date', 'id'=>'datetimepicker_join', 'required' => 'required','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Return Date <span style="color: red">*</span>:</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                    {!! Form::text('end_date', null, array('placeholder' => 'return date', 'id'=>'datetimepicker_confirmation','required' => 'required','class' => 'form-control')) !!}
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




        $(window).bind("load", function() {
            var stateId = $('select[name="book_id"]').val()

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if(stateId) {
                $.ajax({
                    url: '{{Request::root()}}/dashboard/changecopy/ajax/'+stateId,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                        console.log(data);

                        $.each(data, function(index, item) {
                            //now you can access properties using dot notation
                            //console.log(index);
                            $('select[name="copy_number"]').append('<option value="'+ item +'">'+ item +'</option>');
                        });
                        //$('select[name="copy_number"]').append('<option value="'+ data.cities.user_id +'">'+ data.cities.user_name +'</option>');

                    }
                });
                $('select[name="copy_number"]').empty();
            }else{
                $('select[name="copy_number"]').empty();
            }
        });



        $('select[name="book_id"]').on('change', function() {
           var stateId = $(this).val();
            //alert(stateId);
           $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if(stateId) {
                $.ajax({
                    url: '{{Request::root()}}/dashboard/changecopy/ajax/'+stateId,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                        console.log(data);

                        $.each(data, function(index, item) {
                            //now you can access properties using dot notation
                             //console.log(index);
                            $('select[name="copy_number"]').append('<option value="'+ item +'">'+ item +'</option>');
                        });
                        //$('select[name="copy_number"]').append('<option value="'+ data.cities.user_id +'">'+ data.cities.user_name +'</option>');

                    }
                });
                $('select[name="copy_number"]').empty();
            }else{
                $('select[name="copy_number"]').empty();
            }
        });






        function qrPopulateScan(qr) {

            var qrString = qr.replace(/(^[a-zA-Z][-][\d][-])/, '');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            if(qrString) {
                $.ajax({
                    url: '{{Request::root()}}/dashboard/get_data_by_qr_string/ajax/'+qrString,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                        //console.log(data.book_title);

                        $.each(data.bookscopy, function(index, item) {
                            //console.log(item);
                            //now you can access properties using dot notation
                            //console.log(index);
                            //$('select[name="copy_number"]').append('<option value="'+ item +'">'+ item +'</option>');
                        });

                        $('select[name="copy_number"]').append('<option value="'+ qr +'">'+ qr +'</option>');

                        $('select[name="book_id"]').append('<option value="'+ data.book_id +'">'+ data.book_title +'</option>');


                    }
                });
                $('select[name="copy_number"]').empty();
                $('select[name="book_id"]').empty();
            }else{
                $('select[name="copy_number"]').empty();
                $('select[name="book_id"]').empty();
            }





        }








    </script>

@endsection