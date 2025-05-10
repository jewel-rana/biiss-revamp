@extends('master.app')
<?php
use App\Category;
?>
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Details</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('book.index') }}"> Back</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="media">
                <div class="media-left">
                    <a href="#">

                        <?php
                        if( $item->cover_photo == !null){  ?>
                             <img class="media-object img-thumbnail" src="{{Request::root()}}/uploads/books/{{ $item->cover_photo }}" width="350">
                        <?php } else { ?>
                              <img class="media-object img-thumbnail" src="{{Request::root()}}/images/d.jpeg" width="350">
                        <?php }?>


                    </a>
                </div>
                <div class="media-body">
                    <dl class="dl-horizontal">

                        <dt>Title : </dt>
                        <dd>{{ $item->title }}</dd>

                        <dt>Abstraction : </dt>
                        <dd>{{ $item->abstraction }}</dd>

                        <dt>Category : </dt>
                        <dd><?php
                            $category = json_decode($item->category);
                            foreach ($category as $sub){
                                $sInfo = Category::where('id',$sub)->first();
                                echo '<span style="background-color: #bb364c;" class="badge badge-light">' . $sInfo->name.'</span>',' ';
                            }
                            ?></dd>
                        <dt>Tag : </dt>
                        <dd><?php
                            if($item->taggles == !null){
                                $taggles = json_decode($item->taggles);

                                foreach ($taggles as $key=>$val){

                                    echo '<span style="background-color: #ee4157;" class="badge badge-light">'. $val.'</span>',' ';
                                }
                            }

                            ?></dd>

                        <dt>Author : </dt>
                        <dd>{{ $item->author }}</dd>



                        <dt>Edition : </dt>
                        <dd>{{ $item->edition }}</dd>

                        <dt>Publisher : </dt>
                        <dd>{{ $item->publisher }}</dd>

                        <dt>Year of Publication : </dt>
                        <dd>{{ $item->year_of_publication }}</dd>

                        <dt>Self : </dt>
                        <dd>{{ $item->self }}</dd>

                        <dt>Rack : </dt>
                        <dd>{{ $item->rack }}</dd>
                        <dt>Copy : </dt>
                        <dd><?php
                            $copy = json_decode($item->qr_string);
                            foreach ($copy as $cp){

                                echo '<span style="background-color: #eec86d;" class="badge badge-light">' . $cp.'</span>',' ';
                            }

                            ?></dd>

                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection