@extends("{$theme['default']}::layouts.master")
<?php
use App\User;
use App\Book;
?>
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Book Issues list</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('issue.create') }}">New Issues</a>
            </div>
        </div>
    </div>
    <!----------------------search start-------------------------->
    <div class="row">
        <div class="col-lg-4">
            {!! Form::open(array('route' => 'book_issue.index','method'=>'GET')) !!}
            <div class="input-group">
                {!! Form::text('search', null, array('placeholder' => 'Search for...','class' => 'form-control')) !!}
                <span class="input-group-btn">
                 {!! Form::submit('Go!', ['class' => 'btn btn-default']) !!}
                </span>
            </div><!-- /input-group -->
            {!! Form::close() !!}
        </div><!-- /.col-lg-6 -->
    </div><!-- /.row -->
    <!----------------------search end-------------------------->

    <div class="row">
        <div class="col-lg-12">
            <div class="card table-responsive">

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
                        <th>Action</th>
                    </tr>
                    @foreach ($items as $key => $item)
                        <tr>
                            <td>{{ ++$i }}</td>

                            <td>{{ $item->book_title }}</td>

                            <td>{{ $item->copy_number }}</td>

                            <td><?php
                                    $bookInfo = Book::where('id',$item->book_id)->first();
                                    if(count($bookInfo)>0){
                                        echo $bookInfo->author;
                                    }


                                ?></td>

                            <td>
                                <a href="{{ url('dashboard/members/' . $item->user_id ) }}">
                                    {{ $item->user_name }}
                                </a>
                            </td>
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

                            <td class="col-md-4">
                                <div class="btn-group d-flex">
                                    <a class="btn btn-sm btn-info" href="{{ route('issue.edit',$item->id) }}"><i class="fa fa-exchange"></i> Re-Issue</a>

                                    {!! Form::open(['method' => 'DELETE','route' => ['book_issue.destroy', $item->id],'style'=>'display:inline', 'class'=>'delete']) !!}
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-remove"></i></button>
                                    {!! Form::close() !!}
                                </div>
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
