@extends('frontend.app')

@section('owncss')

@endsection
<?php
use App\Category;
use App\BookIssue;
use App\Book;
?>
@section('content_search')

@endsection

@section('content')

<div class="pageContent pt-4" 4>
    <div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="new_book">
                <!-- Set up your HTML -->
                <h2><span 4>Seminar Proceeding</span></h2>
                <div class="row">
                    @foreach ( $items as $key => $item )
                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <div class="thumbnail">
                                <a href="{{ route('single.show',$item->book['id']) }}">
                                    <?php
                                    if( $item->book['cover_photo'] == !null){  ?>
                                    <img style="max-height: 300px; min-height: 300px" src="{{Request::root()}}/uploads/books/{{ $item->book['cover_photo'] }}" alt="book">
                                    <?php } else { ?>
                                    <img src="{{ asset('default/blank-cover.png') }}" alt="book">
                                    <?php }?>


                                    <div class="caption">
                                        <p>{{ $item->book['title'] }}</p>
                                        <h4><?php
                                            $category = json_decode($item->book['category']);
                                            if( !empty( $category ) && count( $category ) ) :
                                                foreach ($category as $sub){
                                                    $sInfo = Category::where('id',$sub)->first();
                                                    echo '<span style="padding:5px;font-size:13px;background-color: #5592cb;width:100%;color:#fff;">'. $sInfo->name.'</span>',' ';
                                                }
                                            endif;
                                            ?></h4>
                                        <p>Author : {{ $item->book['author'] }}</p>
                                        <p>Publication Year : {{ $item->book['year_of_publication'] }}</p>

                                        <?php

                                        $bookIssueInfo = BookIssue::where('is_returned',0)->get();

                                        $issueCopy = [];

                                        foreach ($bookIssueInfo as $issueIn){
                                            $issueCopy[] = $issueIn->copy_number;
                                        }

                                        $qr_string = json_decode($item->book['qr_string']);

                                        $is_available = 0;
                                        if( $qr_string ){
                                            foreach ($qr_string as $qr_s){
                                                if (!in_array($qr_s, $issueCopy)) {

                                                    $is_available = 1;
                                                }
                                            }
                                        }

                                        ?>

                                        <form action="{{ url('/print') }}" method="POST" class="side-by-side">
                                            {!! csrf_field() !!}
                                            <input type="hidden" name="id" value="{{ $item->book['id'] }}">
                                            <input type="hidden" name="title" value="{{ $item->book['title'] }}">
                                            <input type="hidden" name="author" value="{{ $item->book['author'] }}">
                                            <input type="hidden" name="type" value="{{ $item->book['type'] }}">
                                            <?php
                                            if($is_available == 1){
                                            ?>
                                            <input type="submit" class="btn btn-success btn-sm" value="Add to Wishlist">
                                            <?php } else {?>
                                            <input type="button" class="btn btn-warning btn-sm" value="Already Issued">
                                            <?php }?>
                                        </form>

                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {!! $items->appends($_GET)->links() !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('ownjs')

@endsection
