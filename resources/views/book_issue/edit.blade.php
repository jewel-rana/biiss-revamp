@extends("{$theme['default']}::layouts.master")

@section('owncss')
    <link rel="stylesheet" href="{{asset('/date/jquery.datetimepicker.css') }}" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{asset('/tinymce/parsley.css') }}" />

@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Re-Issues</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('issue.index') }}"> Back</a>
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




{!! Form::model($item, ['method' => 'PATCH','route' => ['book_issue.update', $item->id],'files' => true]) !!}
    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="employee_basic_info">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Select Book <span style="color: red">*</span> :</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    <select class="form-control multi-select" name="book_id" required >
                                        @foreach($book as $key=>$employee)
                                            <option value="{{ $key }}" <?php if($item->book_id == $key){ echo 'selected';}?> >{{ $employee }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Copy Number </strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    {!! Form::text('copy_number', $item->copy_number, array('readonly','placeholder' => 'copy number', 'class' => 'form-control show-tick')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Select Member <span style="color: red">*  </span><a href="{{Request::root()}}/dashboard/members/create">Create a new Member</a>  </strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    <select class="form-control multi-select" name="user_id" required >
                                        @foreach($member as $key=>$employee)
                                            <option value="{{ $key }}" <?php if($item->user_id == $key){ echo 'selected';}?> >{{ $employee }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Issue Type <span style="color: red">*</span> :</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    {!! Form::select('type', ['temp'=>'temp', 'per'=>'per'], $item->type, array('required' => 'required','class' => 'form-control show-tick')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Issue Date <span style="color: red">*</span>:</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    {!! Form::text('start_date', $item->start_date, array('placeholder' => 'issue date', 'id'=>'datetimepicker_join_ack', 'required' => 'required','class' => 'form-control', 'readonly')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Return Date <span style="color: red">*</span>:</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    {!! Form::text('end_date', $item->end_date, array('placeholder' => 'return date', 'id'=>'datetimepicker_confirmation','required' => 'required','class' => 'form-control')) !!}
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
    <script src="{{asset('/date/jquery.datetimepicker.full.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $( "#datetimepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#datetimepicker_join" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#datetimepicker_confirmation" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#datetimepicker_termination" ).datepicker({ dateFormat: 'yy-mm-dd' });
    </script>


    <script src="{{asset('/tinymce/parsley.min.js') }}"></script>
    <script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
    <script>
        tinymce.init({
            selector: '#notetextarea',
            plugin: 'link code',
            menubar: false
        });

        tinymce.init({
            selector: '#addresstextarea',
            plugin: 'link code',
            menubar: false
        });
    </script>

@endsection
