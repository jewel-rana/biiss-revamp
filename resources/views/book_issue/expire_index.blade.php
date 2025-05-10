@extends('master.app')
<?php
use App\User;
use App\Book;
?>
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Book Issues expired list</h2>
                <a href="{{Request::root()}}/dashboard/book_issue">See all Issues </a>
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
                        <th>Book Title</th>
                        <th>Copy Number</th>
                        <th>Author Name</th>
                        <th>Member Name</th>
                        <!--<th>Issued By</th>-->
                        <th>Issue Date</th>
                        <th>Return Date</th>
                        <th>Type</th>
                        <th>Status</th>
                        <!--<th>Returned</th>-->
                        <th width="280px">Action</th>
                    </tr>
                    @foreach ($items as $key => $item)
                        <tr>
                            <td>{{ ++$i }}</td>

                            <td>{{ $item->book_title }}</td>

                            <td>{{ $item->copy_number }}</td>

                            <td><?php
                                    $bookInfo = Book::where('id',$item->book_id)->first();
                                    if(count($bookInfo)>0){
                                        echo $bookInfo->aus;
                                    }


                                ?></td>

                            <td>{{ $item->user_name }}</td>
                            <!--<td>
                                <?php
                                    $adminInfo = User::where('id',$item->admin_id)->first();
                                    if(count($adminInfo)>0){
                                        echo $adminInfo->name;
                                    } else {
                                        echo "___";
                                    }
                                ?>
                            </td>-->

                            <td>{{ $item->start_date }}</td>

                            <td>{{ $item->end_date }}</td>

                            <td>{{ $item->type }}</td>

                            <td>
                                <?php
                                $today = date('Y-m-d');
                                if($today > $item->end_date ){
                                    echo '<span style="background-color: red" class="badge badge-danger">Expire</span>';
                                } else {
                                    echo '<span style="background-color: green" class="badge badge-danger">Not expire</span>';
                                }
                                ?>

                            </td>

                            <!--<td>
                                <?php
                                if($item->is_returned == 1){
                                    echo "Yes";
                                } else {
                                    echo "No";
                                }
                                ?>
                            </td>-->

                            <td>

                                <a class="btn btn-primary" href="{{ route('book_issue.edit',$item->id) }}">Re-Issue</a>

                                {!! Form::open(['method' => 'DELETE','route' => ['book.destroy', $item->id],'style'=>'display:inline', 'class'=>'delete']) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
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