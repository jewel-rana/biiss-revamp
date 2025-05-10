@extends('frontend.app')

@section('owncss')

@endsection
<?php
use App\Category;
use App\BookIssue;
use App\Book;
?>


@section('content')

<div class="pageContent pt-4" 4>
    <div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="new_book">
                <!-- Set up your HTML -->
                <h2><span>New Books</span></h2>
                <div class="row">
                    @foreach ($books as $key => $book)
                        <div class="col-xs-12 col-sm-6 col-md-2">
                            <div class="thumbnail">
                                <a href="{{ route('single.show',$book->id) }}">
                                    <?php
                                    if( $book->cover_photo == !null){  ?>
                                    <img style="max-height: 300px; min-height: 300px" src="{{Request::root()}}/uploads/books/{{ $book->cover_photo }}" alt="book">
                                    <?php } else { ?>
                                    <img src="{{ asset('default/blank-cover.png') }}" alt="book">
                                    <?php }?>
                                    <div class="caption">
                                        <p>{{ $book->title }}</p>
                                        <h4><?php
                                            $category = json_decode($book->category);
                                            foreach ($category as $sub){
                                                $sInfo = Category::where('id',$sub)->first();
                                                echo '<div style="padding:5px;font-size:13px;background-color: #5592cb;width:100%;color:#fff;">'. $sInfo->name.'</div>',' ';
                                            }
                                            ?></h4>
                                        <p>Author : {{ $book->author }}</p>
                                        <p>Publication Year : {{ $book->year_of_publication }}</p>

                                        <?php

                                        $bookIssueInfo = BookIssue::where(['is_returned' => 0, 'book_id' => $book->id])->get();

                                        $issueCopy = [];

                                        foreach ($bookIssueInfo as $issueIn){
                                            $issueCopy[] = $issueIn->copy_number;
                                        }

                                        $qr_string = json_decode($book->qr_string);

                                        $is_available = 1;
                                        foreach ($qr_string as $qr_s){
                                            if (!in_array($qr_s, $issueCopy)) {

                                                $is_available = 1;
                                            }
                                        }


                                        ?>

                                        <form action="{{ url('/print') }}" method="POST" class="side-by-side">
                                            {!! csrf_field() !!}
                                            <input type="hidden" name="id" value="{{ $book->id }}">
                                            <input type="hidden" name="title" value="{{ $book->title }}">
                                            <input type="hidden" name="author" value="{{ $book->author }}">
                                            <input type="hidden" name="type" value="{{ $book->type }}">
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
                        {!! $books->appends(Request::except('page'))->render() !!}
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
