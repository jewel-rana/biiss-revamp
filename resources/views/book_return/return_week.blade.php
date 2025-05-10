@extends('master.app')
<?php
use App\User;
use App\BookIssue;
?>
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Return of this week</h2>

                <a href="{{Request::root()}}/dashboard/book_return">See all Returned </a>

            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <table class="table table-bordered">
                    <tr>
                        <th>No</th>
                        <th>Title</th>
                        <th>Copy Number</th>
                        <th>Issued By</th>
                        <th>Member Name</th>
                        <th>Return Date</th>
                        <th>Late Count</th>
                        <th width="280px">Action</th>
                    </tr>
                    @foreach ($items as $key => $item)
                        <?php

                        $bookIssueInfo = BookIssue::where('id',$item->book_issue_id)->first();

                        ?>
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $bookIssueInfo->book_title }}</td>
                            <td>{{ $bookIssueInfo->copy_number }}</td>

                            <td>
                                <?php
                                $adminInfo = User::where('id',$item->admin_id)->first();
                                if(count($adminInfo)>0){
                                    echo $adminInfo->name;
                                } else {
                                    echo "___";
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $memberInfo =User::where('id',$item->user_id)->first();
                                if(count($memberInfo)>0){
                                    echo $memberInfo->name;
                                } else {
                                    echo "___";
                                }

                                ?>

                            </td>
                            <td>{{ $item->return_date }}</td>
                            <td>{{ $item->late_count }}</td>


                            <td>
                                <a class="btn btn-info" href="{{ route('book_return.show',$item->id) }}">Show</a>
                            <!--{!! Form::open(['method' => 'DELETE','route' => ['book_return.destroy', $item->id],'style'=>'display:inline', 'class'=>'delete']) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}-->
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                </table>

                {!! $items->appends(Request::except('page'))->render() !!}
            </div>
        </div>
    </div>

@endsection

@section('ownjs')
    <script>
        $(".delete").on("submit", function(){
            return confirm("Do you want to delete this?");
        });
    </script>
@endsection