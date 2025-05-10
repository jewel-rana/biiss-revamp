@extends('master.app')
<?php
use App\Category;
?>
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Books/Journals/Seminars list</h2>


            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('book.create') }}"> Create</a>
            </div>
        </div>
    </div>
    <!--search start-->
    <div class="row">
        <div class="col-lg-4">
            {!! Form::open(array('route' => 'book.index','method'=>'GET')) !!}
            <div class="input-group">
                {!! Form::text('search', null, array('placeholder' => 'Search....','class' => 'form-control')) !!}
                <span class="input-group-btn">
                 {!! Form::submit('Go!', ['class' => 'btn btn-default']) !!}
                </span>
            </div><!-- /input-group -->
            {!! Form::close() !!}
        </div><!-- /.col-lg-6 -->
    </div><!-- /.row -->
    <!--search end-->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                @if ($message = Session::get('update_success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif

                @if ($returnData = Session::get('update_success'))
                        <div id="myModalOnLoad" class="modal fade" role="dialog">


                            <div class="modal-dialog modal-lg">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">QR code</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div  class="media">
                                            <div id="pQrDiv" class="media-left">
                                                <a href="#">
                                                    <?php
                                                    $qrs = json_decode($returnData['Qr_DD_PRINT']);
                                                    foreach ($qrs as $qr){
                                                    ?>

                                                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate(".$qr.")) !!} ">

                                                    <?php }?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn btn-success" value="Print" onclick="javascript:printDiv('pQrDiv')" />
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>

                            </div>

                        </div>


                    <div class="alert alert-success">
                        <p>{{ $returnData['message'] }}</p>
                    </div>
                @endif

                @if(session()->has('delete_success'))
                    <div class="alert alert-success">
                        <p>{{ session('delete_success') }}</p>
                    </div>
                @endif
                <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th width="5%">No</th>
                        <!--<th>QR</th>-->
                        <th width="20%">Title</th>
                        <th width="5%">Type</th>
                        <th width="5%">Author</th>
                        <!--<th>Publisher</th>-->
                        <th width="5%">Category</th>
                        <!--<th>Tag</th>-->
                        <th width="5%">Self</th>
                        <th width="5%">Rack</th>
                        <th width="5%">Cover</th>
                        <th width="5%">PDF</th>
                        <th width="40%">Action</th>
                    </tr>
                    @if( !empty( $items ) && is_object( $items ) )
                    @foreach ($items as $key => $item)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <!--<td>
                                <img style="width: 100px" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(500)->generate(".$item->qr_string.")) !!} ">

                            </td>-->
                            <td><a href="{{ url('dashboard/book/' . $item->id ) }}" target="_blank" title="{{ $item->title }}">
                            <?php
                            // $pos=strpos($item->title, ' ', 50);
                            $title = substr($item->title,0,50 );
                            echo $title . '...';
                            ?>
                            </a></td>
                            <td>{{ ucwords($item->type) }}</td>
                            <td>
                            {{ $item->author }}
                            </a>
                            </td>
                            <!--<td>{{ $item->publisher }}</td>-->
                            <td>

                                <?php
                                    $category = json_decode($item->category);
                                    foreach ($category as $sub){
                                        $sInfo = Category::where('id',$sub)->first();
                                        echo '<div style="background-color: #bb364c;width:100%;" class="badge badge-light">' . $sInfo->name.'</div>',' ';
                                    }
                                ?>

                            </td>

                            <td>{{ $item->self }}</td>
                            <td>{{ $item->rack }}</td>
                            <td>
                                <?php
                                if( $item->cover_photo == !null){  ?>
                                    <img src="{{Request::root()}}/uploads/books/{{ $item->cover_photo }}" width="50" height="50">
                                <?php } else { ?>
                                     <img src="{{Request::root()}}/images/smallbook.jpeg" width="50" height="50">
                                <?php }?>



                            </td>


                            <td>
                                <?php
                                if( $item->file == !null){
                                ?>
                                <a class="btn btn-info" target="_blank" href="{{Request::root()}}/uploads/books/{{ $item->file }}">View</a>
                                <?php } else { echo 'N/A';}?>
                            </td>

                            <td>
                                <div class="btn-group w-100 d-flex" role="group" aria-label="Basic example" style="margin-bottom:10px;width:100%;">
                                    <a type="button" class="btn btn-warning btn-sm col-sm-6" data-toggle="modal" data-target="#myModal<?php echo $item->id;?>">
                                        <i class="fa fa-qrcode"></i> QR
                                    </a>
                                    <a class="btn btn-sm btn-info col-sm-6" href="{{ route('dashboard.item.show',$item->id) }}"><i class="fa fa-eye"></i> View</a>
                                </div>
                                <div class="btn-group" role="group" aria-label="Basic example" style="width:100%;">
                                    <a class="btn btn-sm btn-success col-sm-6" href="{{ url('dashboard/library/' . $item->id . '/edit/?type=' . $item->type) }}">
                                    <i class="fa fa-edit"></i> Edit
                                    </a>
                                    {!! Form::open(['method' => 'DELETE','route' => ['book.destroy', $item->id],'style'=>'display:inline', 'class'=>'delete']) !!}
                                    <button class="btn btn-sm btn-danger col-sm-6" type="submit"><i class="fa fa-remove"></i> Delete</button>
                                    {!! Form::close() !!}
                                </div>
                            </td>
                        </tr>
                        <div class="modal fade" id="myModal<?php echo $item->id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">QR {{ $item->title }}</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div>

                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                <div role="tabpanel" class="tab-pane active" id="home<?php echo $item->id;?>">

                                                    <div  class="media">
                                                        <div id="pQrDiv<?php echo $item->id;?>" class="media-left">
                                                            <a href="#">
                                                                <?php
                                                                $qrs = json_decode($item->qr_string);
                                                                if( !empty($qrs))
                                                                foreach ($qrs as $qr){
                                                                ?>

                                                                <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate(".$qr.")) !!} ">

                                                                <?php } ?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <form>
                                            <input type="button" class="btn btn-success" value="Print" onclick="javascript:printDiv('pQrDiv<?php echo $item->id;?>')" />
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @else
                        <tr>
                            <td colspan="10">
                                <div class="alert alert-warning">
                                    <h4>!Empty List</h4>
                                    <p>Sorry! no items found.</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </table>

                    {!! $items->appends(Request::except('page'))->render() !!}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('ownjs')


    <script type="text/javascript">
        $(window).on('load',function(){
            $('#myModalOnLoad').modal('show');
        });
    </script>

    <script>
        $(".delete").on("submit", function(){
            return confirm("Do you want to delete this?");
        });
    </script>



    <script language="javascript" type="text/javascript">
        function printDiv(divID) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
            document.body.innerHTML =
                "<body><div style='text-align:center;'><h2>Bangladesh Institute of International and Strategic Studies (BIISS)</h2><h4>Books Info For Print</h4></div>" +
                divElements + "</body>";

            //Print Page
            window.print();

            //location.reload(true);

            //Restore orignal HTML

            document.body.innerHTML = oldPage;

            var url = "{{Request::root()}}/dashboard/book";
            window.location.href = url;


        }



    </script>


@endsection