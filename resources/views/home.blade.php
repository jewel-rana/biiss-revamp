@extends("{$theme['default']}::layouts.master")

@section('owncss')
    <link rel="stylesheet" href="{{asset('/date/jquery.datetimepicker.css') }}" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{asset('/css/select2.min.css') }}" />
    <style>
        .modal-dialog {
            width: 65%;
            margin: 0 auto;
        }
        .chart_content{

        }
   </style>
@endsection

<?php

use App\Library;
use App\LibraryIssue;
use Carbon\Carbon;

?>

@section('content')



<div class="block-header">
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

    </div>
</div>






<!----------------------search start-------------------------->
<div class="row">
    <div class="col-lg-12">
        {!! Form::open(array('route' => 'home.index','method'=>'GET')) !!}
        <div class="input-group home_search">
              {!! Form::text('search', null, array('placeholder' => 'Search for...','class' => 'form-control')) !!}
            <span class="input-group-btn">
              {!! Form::submit('Go!', ['class' => 'btn btn-default']) !!}
            </span>
        </div><!-- /input-group -->
        {!! Form::close() !!}
    </div><!-- /.col-lg-6 -->
</div><!-- /.row -->
<!----------------------search end-------------------------->
<!-- Widgets -->



@if(isset($searchresult) & !empty($searchresult))



@else
<!-- Basic Example -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <div class="col-md-6">
                    <h4 style="text-align: center"><b>Library Stats</b></h4>
                </div>
                <div class="col-md-6">
                    <h4 style="text-align: center"><b>Issue Stats</b></h4>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="body">
                <div class="row clearfix">
                    <div class="col-md-6" style="text-align: center;">

                        <div id="pie_chart2" class="flot-chart"></div>
                        <div class="graphInfo left">
                            <ul class="nav nav-flex">
                            @foreach( $info as $inf )
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('dashboard/book/?type=' . $inf->type ) }}"><i class="fa fa-book"></i> {{ $inf->type }} : {{ $inf->total }}</a>
                                </li>
                            @endforeach
                                <li class="nav-item">
                                    <a href="{{ url('dashboard/book') }}" class="nav-link">
                                        <i class="fa fa-book"></i> Total : <?php echo  $info[0]->total + $info[1]->total + $info[2]->total; ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6" style="text-align: center;">

                        <div id="pie_chart3" class="flot-chart"></div>
                        <div class="graphInfo left">
                            <ul class="nav nav-flex">
                                <li class="nav-item">
                                    <a href="{{url('dashboard/book_issue')}}" class="nav-link">
                                        <i class="fa fa-cube"></i> Total : {{ $issues['total'] }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{url('dashboard/book_issue/?type=active')}}"><i class="fa fa-check"></i> Active : {{ $issues['active'] }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{url('dashboard/book_issue/?type=expired')}}"><i class="fa fa-ban"></i> Expired : {{ $issues['expired'] }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>




<div class="row clearfix">
    <!-- Task Info -->
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="return_of_this_week">

            <div class="list-group">

                <a href="{{Request::root()}}/dashboard/book_issues/return" class="list-group-item active">
                    <h4 class="list-group-item-heading">Return of the week</h4>
                    <p class="list-group-item-text">List of Book return of this week</p>
                </a>



                <?php

                foreach ($return_of_week as $reItem){

                $issueInfo = BookIssue::where('id',$reItem->book_issue_id)->first();

                $bookInfo = Book::where('id',$issueInfo->book_id)->first();
                // dd( $bookInfo['cover_photo'] );
                ?>
                <a href="#" class="list-group-item">
                    <img class="pull-right" src="{{Request::root()}}/uploads/books/{{ $bookInfo->cover_photo }}" width="60" height="80">
                    <h4 class="list-group-item-heading">Title : {{ $issueInfo->book_title }}</h4>
                    <p class="list-group-item-text">Member Name : {{ $issueInfo->user_name }}</p>
                    <p class="list-group-item-text">Issue Date : {{ $issueInfo->start_date }}</p>
                    <p class="list-group-item-text">Return Date : {{ $issueInfo->end_date }}</p>
                </a>

                <?php
                }
                ?>
            </div>

        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="return_expired">
            <div class="list-group">
                <a href="{{Request::root()}}/dashboard/book_issues/expired" class="list-group-item active">
                    <h4 class="list-group-item-heading">Return expired</h4>
                    <p class="list-group-item-text">Total number of return date over.</p>
                </a>

                <?php

                    foreach ($return_expired as $exItem){
                        $bookInfo = Library::where('id',$exItem->book_id)->first();

                ?>
                <a href="#" class="list-group-item">
                    <img class="pull-right" src="{{Request::root()}}/uploads/books/{{ $bookInfo->cover_photo }}" width="60" height="80">
                    <h4 class="list-group-item-heading">Title : {{ $exItem->book_title }}</h4>
                    <p class="list-group-item-text">Member Name : {{ $exItem->user_name }}</p>
                    <p class="list-group-item-text">Issue Date : {{ $exItem->start_date }}</p>
                    <p class="list-group-item-text">Return Date : {{ $exItem->end_date }}</p>



                </a>

                <?php
                }
                ?>


            </div>
        </div>
    </div>

</div>
@endif






@if(isset($searchresult) & !empty($searchresult))



    <div class="row clearfix">
        <!-- Task Info -->

        <?php
        //echo "<pre>";
        //print_r($paginator_data);
        ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <table class="table table-bordered">
                <tr>
                    <th>No</th>
                    <th>Book or Member</th>
                    <th>Image</th>
                    <th>Action</th>


                </tr>
                @foreach ($searchresult as $key => $paginator_data)

                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>
                            <?php
                            if(!empty($paginator_data['type'])){
                                echo $paginator_data['title'];
                            }else{
                                echo $paginator_data['name'];
                            }
                            ?>
                        </td>
                        <td>
                            @if(!empty($paginator_data['type']) & isset($paginator_data['type']))
                                <img src="{{Request::root()}}/uploads/books/{{ $paginator_data['cover_photo'] }}" width="60" height="45">
                            @else

                                <img src="{{Request::root()}}/uploads/profile/{{ $paginator_data['avatar'] }}" width="60" height="45">
                            @endif
                        </td>
                        <td>

                            @if(!empty($paginator_data['type']) & isset($paginator_data['type']))
                                <!-- Trigger the modal with a button -->
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal{{ $paginator_data['id'] }}">Details</button>

                                <!-- Modal -->

                                <div id="myModal{{ $paginator_data['id'] }}" class="modal fade" role="dialog">
                                    <div class="modal-dialog modal-lg">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title"> Info of {{  $paginator_data['title'] }}</h4>
                                            </div>
                                            <div class="modal-body">

                                                <div id="printablediv" style="display: none">
                                                    <table class="table table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th>User Name</th>
                                                            <th>Book Name</th>
                                                            <th>Book Image</th>
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




                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                        <img class="img-thumbnail" src="{{Request::root()}}/uploads/books/{{ $paginator_data['cover_photo'] }}" width="" height="310">
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                                                        <dl class="dl-horizontal">

                                                            <dt>Title : </dt>
                                                            <dd>{{ $paginator_data['title'] }}</dd>

                                                            <dt>Abstraction : </dt>
                                                            <dd>{{ $paginator_data['abstraction'] }}</dd>

                                                            <dt>Origin : </dt>
                                                            <dd>{{ $paginator_data['origin'] }}</dd>

                                                            <dt>Author : </dt>
                                                            <dd>{{ $paginator_data['author'] }}</dd>

                                                            <dt>Publisher : </dt>
                                                            <dd>{{ $paginator_data['publisher'] }}</dd>



                                                            <dt>Publisher : </dt>
                                                            <dd>{{ $paginator_data['publisher'] }}</dd>

                                                            <dt>Year of Publication : </dt>
                                                            <dd>{{ $paginator_data['year_of_publication'] }}</dd>

                                                            <dt>Self : </dt>
                                                            <dd>{{ $paginator_data['self'] }}</dd>

                                                            <dt>Rack : </dt>
                                                            <dd>{{ $paginator_data['rack'] }}</dd>

                                                            <dt>ISBN Number : </dt>
                                                            <dd>{{ $paginator_data['isbn'] }}</dd>



                                                        </dl>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <?php

                                                        $issueInfoall = BookIssue::where('book_id',$paginator_data['id'])->where('is_returned',0)->get();

                                                        if(count($issueInfoall)>0){?>




                                                            <table class="table">
                                                                <thead>
                                                                <tr>
                                                                    <th>Book Title</th>
                                                                    <th>Copy Number</th>
                                                                    <th>Member Name</th>
                                                                    <th>Return Date</th>
                                                                    <th>Today</th>
                                                                    <th>Late / Nor</th>
                                                                    <th>Fine</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                   <?php
                                                                   foreach($issueInfoall as $issueInfo){


                                                                    ?>
                                                                    <tr>
                                                                        <td>{{ $issueInfo->book_title }}</td>
                                                                        <td>{{ $issueInfo->copy_number }}</td>
                                                                        <td>{{ $issueInfo->user_name }}</td>

                                                                        <td>{{ $issueInfo->end_date }}</td>
                                                                        <td>{{ Carbon::now()->format('Y-m-d') }}</td>
                                                                        <td>
                                                                            <?php

                                                                            $date = Carbon::parse($issueInfo->end_date);
                                                                            $date_end = Carbon::parse($issueInfo->end_date)->format('Y-m-d');
                                                                            $now = Carbon::now()->format('Y-m-d');

                                                                             $diff = $date->diffInDays($now);
                                                                            ?>

                                                                            <?php
                                                                                if (Carbon::now()->between(Carbon::parse($issueInfo->start_date), Carbon::parse($issueInfo->end_date))){
                                                                                    echo "0";
                                                                                }else{
                                                                                    echo $diff;
                                                                                }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                          <?php
                                                                            if (Carbon::now()->between(Carbon::parse($issueInfo->start_date), Carbon::parse($issueInfo->end_date))){
                                                                                echo "0";
                                                                            }else{
                                                                                if($paginator_data['origin']=='local'){
                                                                                    echo $diff*10;
                                                                                }else{
                                                                                    echo $diff*50;
                                                                                }
                                                                            }
                                                                           ?>
                                                                        </td>
                                                                        <td>
                                                                        <?php


                                                                            if (Carbon::now()->between(Carbon::parse($issueInfo->start_date), Carbon::parse($issueInfo->end_date))){
                                                                         ?>


                                                                            <div id="create-item{{$issueInfo->id}}">


                                                                                {!! Form::open(array('route' => 'book_return.store','method'=>'POST')) !!}
                                                                                {!! Form::hidden('book_issue_code', $issueInfo->book_issue_code, array('placeholder' => 'book_issue_code', 'id'=>'book_issue_code', 'required' => 'required','class' => 'form-control','readonly' => 'true')) !!}
                                                                                {!! Form::hidden('user_id', $issueInfo->user_id, array('placeholder' => 'user_id', 'id'=>'user_id', 'required' => 'required','class' => 'form-control','readonly' => 'true')) !!}
                                                                                {!! Form::hidden('end_issue_date', $date_end, array('placeholder' => 'End issue date', 'id'=>'end_issue_date', 'required' => 'required','class' => 'form-control','readonly' => 'true')) !!}
                                                                                {!! Form::hidden('return_date', $now, array('placeholder' => 'start_date', 'id'=>'datetimepicker_join', 'required' => 'required','class' => 'form-control')) !!}
                                                                                <!--<button type="submit" class="btn btn-primary  crud-submit"  data-dismiss="modal" data-backdrop="false">Return</button>-->
                                                                                <button type="submit" class="btn btn-primary  crud-submit"  data-dismiss="modal" data-backdrop="false">Return</button>
                                                                                {!! Form::close() !!}

                                                                            </div>


                                                                           <?php }else{?>


                                                                            <div id="create-item{{$issueInfo->id}}">


                                                                                {!! Form::open(array('route' => 'book_return.store','method'=>'POST')) !!}
                                                                                {!! Form::hidden('book_issue_code', $issueInfo->book_issue_code, array('placeholder' => 'book_issue_code', 'id'=>'book_issue_code', 'required' => 'required','class' => 'form-control','readonly' => 'true')) !!}
                                                                                {!! Form::hidden('user_id', $issueInfo->user_id, array('placeholder' => 'user_id', 'id'=>'user_id', 'required' => 'required','class' => 'form-control','readonly' => 'true')) !!}
                                                                                {!! Form::hidden('end_issue_date', $date_end, array('placeholder' => 'End issue date', 'id'=>'end_issue_date', 'required' => 'required','class' => 'form-control','readonly' => 'true')) !!}
                                                                                {!! Form::hidden('return_date', $now, array('placeholder' => 'start_date', 'id'=>'datetimepicker_join', 'required' => 'required','class' => 'form-control')) !!}
                                                                                <button type="submit" class="btn btn-primary  crud-submit"  data-dismiss="modal" data-backdrop="false">Return</button>
                                                                                {!! Form::close() !!}

                                                                            </div>
                                                                            <a class="btn btn-primary" href="{{ route('issue.edit',$issueInfo->id) }}">Re-Issue</a>


                                                                            <?php }
                                                                           ?>


                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                       }
                                                                    ?>

                                                                </tbody>
                                                            </table>
                                                        <?php
                                                        }else{?>
                                                            <a class="btn btn-success" style="float: left" href="{{ route('issue.create',$paginator_data['id']) }}">New Issues Book</a>
                                                      <?php }
                                                      ?>


                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @else



                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal{{ $paginator_data['id'] }}">profile</button>

                                    <!-- Modal -->
                                    <div id="myModal{{ $paginator_data['id'] }}" class="modal fade" role="dialog">
                                        <div class="modal-dialog modal-lg">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Info of {{ $paginator_data['name'] }}</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">

                                                            <img class="img-thumbnail" src="{{Request::root()}}/uploads/profile/{{ $paginator_data['avatar'] }}" width="310">
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                                                            <dl class="dl-horizontal">

                                                                <dt>Name : </dt>
                                                                <dd>{{ $paginator_data['name'] }}</dd>


                                                                <dt>Email : </dt>
                                                                <dd>{{ $paginator_data['email'] }}</dd>

                                                                <dt>Contact number : </dt>
                                                                <dd>{{ $paginator_data['contact_number'] }}</dd>

                                                                <dt>Address : </dt>
                                                                <dd>{{ $paginator_data['address'] }}</dd>

                                                            </dl>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                             <?php
                                                               $user_issue_history = BookIssue::where('user_id',$paginator_data['id'])->where('is_returned',0)->get();


                                                               if(count($user_issue_history)>0){
                                                                ?>

                                                                 <div id="printablediv" style="display: none">
                                                                     <table class="table table-striped">
                                                                         <thead>
                                                                         <tr>
                                                                             <th>User Name</th>
                                                                             <th>Book Title</th>
                                                                             <th>Book Image</th>
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





                                                                 <table class="table">
                                                                     <thead>
                                                                     <tr>
                                                                         <th>Book Title</th>
                                                                         <th>Image</th>
                                                                         <th>User Name</th>
                                                                         <th>Retun Date</th>
                                                                         <th>Today</th>
                                                                         <th>Late / Nor</th>
                                                                         <th>Fine</th>
                                                                         <th>Action</th>
                                                                     </tr>
                                                                     </thead>
                                                                     <tbody>
                                                                            <?php
                                                                             foreach($user_issue_history as $key=>$single_issue_history){
                                                                             ?>

                                                                                <tr>
                                                                                    <td>{{$single_issue_history->book_title}}</td>
                                                                                    <td>
                                                                                        <?php
                                                                                        $bookInfoForMember = Book::where('id',$single_issue_history->book_id)->first();

                                                                                        ?>

                                                                                        <img class="img-thumbnail" src="{{Request::root()}}/uploads/books/{{ $bookInfoForMember->cover_photo }}" width="60" height="60">


                                                                                    </td>
                                                                                    <td>{{$single_issue_history->user_name}}</td>
                                                                                    <td>{{$single_issue_history->end_date}}</td>
                                                                                    <td>{{ Carbon::now()->format('Y-m-d') }}</td>
                                                                                    <td>
                                                                                       <?php
                                                                                            $single_issue_history2 = Carbon::parse($single_issue_history->end_date);
                                                                                            $date_end2 = Carbon::parse($single_issue_history->end_date)->format('Y-m-d');
                                                                                            $now2 = Carbon::now()->format('Y-m-d');
                                                                                            $diff_issue2 = $single_issue_history2->diffInDays($now2);


                                                                                        ?>
                                                                                        <?php
                                                                                        if (Carbon::now()->between(Carbon::parse($single_issue_history->start_date), Carbon::parse($single_issue_history->end_date))){
                                                                                                echo "0";
                                                                                            }else{
                                                                                                echo $diff_issue2;
                                                                                            }
                                                                                        ?>
                                                                                    </td>
                                                                                    <td>

                                                                                        <?php
                                                                                        if (Carbon::now()->between(Carbon::parse($single_issue_history->start_date), Carbon::parse($single_issue_history->end_date))){
                                                                                             echo "0";
                                                                                        }else{
                                                                                              if($bookInfoForMember->origin=="local"){
                                                                                                echo $diff_issue2*10;
                                                                                              }else{
                                                                                                echo $diff_issue2*50;
                                                                                              }
                                                                                        }
                                                                                        ?>

                                                                                    </td>
                                                                                    <td>
                                                                                        <?php
                                                                                        if (Carbon::now()->between(Carbon::parse($single_issue_history->start_date), Carbon::parse($single_issue_history->end_date))){
                                                                                        ?>
                                                                                            <div id="create-item{{$single_issue_history->id}}">

                                                                                                {!! Form::open(array('route' => 'book_return.store','method'=>'POST')) !!}
                                                                                                {!! Form::hidden('book_issue_code', $single_issue_history->book_issue_code, array('placeholder' => 'book_issue_code', 'id'=>'book_issue_code', 'required' => 'required','class' => 'form-control','readonly' => 'true')) !!}
                                                                                                {!! Form::hidden('user_id', $single_issue_history->user_id, array('placeholder' => 'user_id', 'id'=>'user_id', 'required' => 'required','class' => 'form-control','readonly' => 'true')) !!}
                                                                                                {!! Form::hidden('end_issue_date', $date_end2, array('placeholder' => 'End issue date', 'id'=>'end_issue_date', 'required' => 'required','class' => 'form-control','readonly' => 'true')) !!}
                                                                                                {!! Form::hidden('return_date', $now2, array('placeholder' => 'start_date', 'id'=>'datetimepicker_join', 'required' => 'required','class' => 'form-control')) !!}
                                                                                                <button type="submit" class="btn btn-primary  crud-submit"  data-dismiss="modal" data-backdrop="false">Return</button>
                                                                                                {!! Form::close() !!}

                                                                                            </div>

                                                                                        <?php }else{?>


                                                                                            <div id="create-item{{$single_issue_history->id}}">

                                                                                                {!! Form::open(array('route' => 'book_return.store','method'=>'POST')) !!}
                                                                                                {!! Form::hidden('book_issue_code', $single_issue_history->book_issue_code, array('placeholder' => 'book_issue_code', 'id'=>'book_issue_code', 'required' => 'required','class' => 'form-control','readonly' => 'true')) !!}
                                                                                                {!! Form::hidden('user_id', $single_issue_history->user_id, array('placeholder' => 'user_id', 'id'=>'user_id', 'required' => 'required','class' => 'form-control','readonly' => 'true')) !!}
                                                                                                {!! Form::hidden('end_issue_date', $date_end2, array('placeholder' => 'End issue date', 'id'=>'end_issue_date', 'required' => 'required','class' => 'form-control','readonly' => 'true')) !!}
                                                                                                {!! Form::hidden('return_date', $now2, array('placeholder' => 'start_date', 'id'=>'datetimepicker_join', 'required' => 'required','class' => 'form-control')) !!}
                                                                                                <button type="submit" class="btn btn-primary  crud-submit"  data-dismiss="modal" data-backdrop="false">Return</button>
                                                                                                {!! Form::close() !!}

                                                                                            </div>
                                                                                            <a class="btn btn-primary" href="{{ route('issue.edit',$single_issue_history->id) }}">Re-Issue</a>



                                                                                        <?php }
                                                                                        ?>
                                                                                    </td>
                                                                                </tr>

                                                                             <?php
                                                                             }
                                                                            ?>

                                                                      </tbody>
                                                                 </table>
                                                               <?php
                                                               }
                                                               ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                            @endif

                        </td>

                    </tr>
                @endforeach
            </table>


            {{ $searchresult->setpath(Request::root().'/dashboard/home?search='.$search)->render() }}


        </div>
    </div>
@endif



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




    $('.crud-submit').on('click', function(e) {

        e.preventDefault();


       // var id = $(this).parent("td").data('id');
       // myparent = $(e.target).parent();
        //alert(myparent.id);

        var parent_id = $(e.target).closest("div").attr('id');

        //console.log(iddd);


        var form_action = $('#'+parent_id+'').find("form").attr("action");
        var book_issue_code = $('#'+parent_id+'').find("input[name='book_issue_code']").val();

        var user_id = $('#'+parent_id+'').find("input[name='user_id']").val();
        var end_issue_date = $('#'+parent_id+'').find("input[name='end_issue_date']").val();
        var return_date = $('#'+parent_id+'').find("input[name='return_date']").val();


       //console.log(book_issue_code);


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
                    "<html><head><title>Books Info For Print</title></head><body><div style='text-align:center;'><h2><b>Bangladesh Institute of International and Strategic Studies (BIISS)</b></h2><h4>Books Info For Print</h4></div>" +
                    divElements + "</body>";
                window.print();
                document.body.innerHTML = oldPage;
                var url = "{{Request::root()}}/dashboard/book_return";
                window.location.href = url;

            }
        });




    });


</script>




<script type="text/javascript">
    //var seminar=0;


    $(function () {
        var pieChartData = [], pieChartSeries = 3;
        var pieChartColors = ['#f19900', '#52bdd5', '#3c9788'];
        var pieChartDatas = [{{ $info[0]->total }}, {{ $info[1]->total }}, {{ $info[2]->total }}];

        pieChartData[0] = {
                label: "{{ ucfirst($info[0]->type) }} : {{ $info[0]->total }}",
                data: pieChartDatas[0],
                color: pieChartColors[0]
        }
        pieChartData[1] = {
                label: "{{ ucfirst($info[1]->type) }} : {{ $info[1]->total }}",
                data: pieChartDatas[1],
                color: pieChartColors[1]
        }
        pieChartData[2] = {
                label: "{{ ucfirst($info[2]->type) }} : {{ $info[2]->total }}",
                data: pieChartDatas[2],
                color: pieChartColors[2]
        }
        $.plot('#pie_chart2', pieChartData, {
            series: {
                pie: {
                    show: true,
                    radius: 0.7,
                    label: {
                        show: true,
                        radius: 3.5 / 4,
                        formatter: labelFormatter,
                        background: {
                            opacity: 0.5
                        }
                    }
                }
            },
            legend: {
                show: false
            }
        });
        function labelFormatter(label, series) {
            return '<div style="font-size:16px; text-align:center; padding:2px; color:#000;">' + label + '<br/>' + Math.round(series.percent) + '%</div>';
        }

    });
</script>

<script type="text/javascript">
    $(function () {
        var pieChartData = [], pieChartSeries = 2;
        var pieChartColors = ['#ee4134', '#3c9788'];
        var pieChartDatas = [{{ $issues['expired'] }}, {{ $issues['active'] }}];

        for (var i = 0; i < pieChartSeries; i++) {
            if(i==0){
                var total='Expired - '+ pieChartDatas[i];
            }else{
                var total='Valid - '+ pieChartDatas[i];
            }
            pieChartData[i] = {
                label: total,
                data: pieChartDatas[i],
                color: pieChartColors[i]
            }
        }
        $.plot('#pie_chart3', pieChartData, {
            series: {
                pie: {
                    show: true,
                    radius: 0.7,
                    label: {
                        show: true,
                        radius: 3.5 / 4,
                        formatter: labelFormatter,
                        background: {
                            opacity: 0.5
                        }
                    }
                }
            },
            legend: {
                show: false
            }
        });
        function labelFormatter(label, series) {
            return '<div style="font-size:16px; text-align:center; padding:2px; color:#000;">' + label + '<br/>' + Math.round(series.percent) + '%</div>';
        }

    });
</script>
@endsection
