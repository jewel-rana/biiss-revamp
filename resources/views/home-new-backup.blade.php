@extends('layouts.app')

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
<script type="text/javascript" src="{{ asset('plugins/chartjs/Chart.min.js') }}"></script>
@endsection

<?php

use App\Book;
use App\BookIssue;
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
              {!! Form::text('search', null, array('placeholder' => 'Search for...','class' => 'seach_place_holder form-control')) !!}
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
                <h4 style="text-align: center"><b>STATUS</b></h4>
               {{-- <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);">Action</a></li>
                            <li><a href="javascript:void(0);">Another action</a></li>
                            <li><a href="javascript:void(0);">Something else here</a></li>
                        </ul>
                    </li>
                </ul>--}}
            </div>
            <div class="body">
                <div class="row clearfix">
                    <div class="col-md-6" style="text-align: center;">

                        <canvas id="pieChart1"></canvas>
                    </div>
                    <div class="col-md-6" style="text-align: center;">

                        <canvas id="pieChart2"></canvas>
                    </div>
                    <div class="col-md-6" style="text-align: center;">

                        <canvas id="pieChart3"></canvas>
                    </div>
                    <div class="col-md-6" style="text-align: center;">

                        <canvas id="pieChart4"></canvas>
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
                    <h3 class="list-group-item-heading1">Return of the week</h3>
                    <p class="list-group-item-text">List of Book return of this week</p>
                </a>



                <?php

                foreach ($return_of_week as $reItem){

                $issueInfo = BookIssue::where('id',$reItem->book_issue_id)->first();

                $bookInfo = Book::where('id',$issueInfo->book_id)->first();


                ?>
                <a href="#" class="list-group-item">



                    <?php
                    if( $bookInfo->cover_photo == !null){  ?>
                        <img class="pull-right" src="{{Request::root()}}/uploads/books/{{ $bookInfo->cover_photo }}" width="60" height="80">
                    <?php } else { ?>
                    <img class="pull-right" src="{{Request::root()}}/images/smallbook.jpeg" width="60" height="80" alt="book">
                    <?php }?>





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
                    <h3 class="list-group-item-heading1">Return expired</h3>
                    <p class="list-group-item-text">List of book return date over</p>
                </a>

                <?php

                    foreach ($return_expired as $exItem){
                        $bookInfo = Book::where('id',$exItem->book_id)->first();

                ?>
                <a href="#" class="list-group-item">


                    <?php
                    if( $bookInfo->cover_photo == !null){  ?>
                    <img class="pull-right" src="{{Request::root()}}/uploads/books/{{ $bookInfo->cover_photo }}" width="60" height="80">
                    <?php } else { ?>
                    <img class="pull-right" src="{{Request::root()}}/images/smallbook.jpeg" width="60" height="80" alt="book">
                    <?php }?>


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
<script>

        var config = {
            type: 'pie',
            data: {
                datasets: [{
                    data: [
                        60, 90
                    ],
                    backgroundColor: [
                        "red",
                        "Orange",
                    ],
                    label: 'Dataset 1'
                }],
                labels: [
                    'Red',
                    'Orange'
                ]
            },
            options: {
                responsive: true
            }
        };
        var config2 = {
            type: 'pie',
            data: {
                datasets: [{
                    data: [
                        60, 90
                    ],
                    backgroundColor: [
                        "red",
                        "Orange",
                    ],
                    label: 'Dataset 1'
                }],
                labels: [
                    'Red',
                    'Orange'
                ]
            },
            options: {
                responsive: true
            }
        };
        var config3 = {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [
                        60, 90
                    ],
                    backgroundColor: [
                        "red",
                        "Orange",
                    ],
                    label: 'Dataset 1'
                }],
                labels: [
                    'Red',
                    'Orange'
                ]
            },
            options: {
                responsive: true
            }
        };

        var config4 = {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [
                        60, 90
                    ],
                    backgroundColor: [
                        "red",
                        "Orange",
                    ],
                    label: 'Dataset 1'
                }],
                labels: [
                    'Red',
                    'Orange'
                ]
            },
            options: {
                responsive: true
            }
        };

        window.onload = function() {
            var ctx = document.getElementById('pieChart1').getContext('2d');
            var ctx2 = document.getElementById('pieChart2').getContext('2d');
            var ctx3 = document.getElementById('pieChart3').getContext('2d');
            var ctx4 = document.getElementById('pieChart4').getContext('2d');
            window.myPie = new Chart(ctx, config);
            window.myPie = new Chart(ctx2, config2);
            window.myPie = new Chart(ctx3, config3);
            window.myPie = new Chart(ctx4, config4);
        };

    </script>

@endsection
