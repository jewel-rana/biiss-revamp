@extends('frontend.app')

@section('owncss')
    <link rel="stylesheet" href="{{asset('/owlcarousel/assets/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('/owlcarousel/assets/owl.theme.default.min.css')}}">
@endsection
<?php
use App\Category;
use App\BookIssue;
use App\Book;
?>

@section('content')
<section class="newitems" 4>
    <div class="container">
        <div class="row">
         <div class="col-xs-12 col-sm-12 col-md-12">
             <div class="new_book">
                 <!-- Set up your HTML -->
                 <h2><span style="background-color: #D5E5E6;">New Books</span></h2>

                 <div class="owl-carousel owl-carousel1">

                    @if( !empty( $books ) && is_object( $books ) )
                          <div>
                             <div class="thumbnail">
                                 <a href="{{ route('single.show',$book->id) }}">



                                     <?php
                                     if( $book->cover_photo != null){  ?>
                                     <img src="{{Request::root()}}/uploads/books/{{ $book->cover_photo }}" alt="book">
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

                                         $bookIssueInfo = BookIssue::where('is_returned',0)->get();

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
                                             <input type="hidden" name="cover_photo" value="{{ $book->cover_photo }}">
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

                    @else

                        <div class="alert alert-warning">
                            <strong>Sorry!</strong> No items selected in this section
                        </div>

                    @endif

                 </div>

             </div>
         </div>
    </div>
</div>
</section>

{{-- <div class="main-divider first-divider"></div> --}}

<section class="topItems" style="background: #5ad1d8;">
    <div class="container">
     <div class="row">
         <div class="col-xs-12 col-sm-12 col-md-6">
             <div class="new_book">
                 <!-- Set up your HTML -->
                 <h2><span style="background-color: #5ad1d8;">Top Books</span></h2>
                 <div class="owl-carousel">
                    @if( count( $topBooks ) )
                     @foreach ($topBooks as $tBook)
                         <div>
                             <div class="thumbnail">
                                 <a href="{{ route('single.show',$tBook->id) }}">

                                     <?php
                                     if( $tBook->cover_photo != null){  ?>
                                     <img src="{{Request::root()}}/uploads/books/{{ $tBook->cover_photo }}" alt="book">
                                     <?php } else { ?>
                                     <img src="{{ asset('default/blank-cover.png') }}" alt="book">
                                     <?php }?>


                                     <div class="caption">
                                         <p>{{ $tBook->book['title'] }}</p>
                                         <h4><?php
                                             $category = json_decode($tBook->book['category']);
                                             foreach ($category as $sub){
                                                 $sInfo = Category::where('id',$sub)->first();
                                                 echo '<span style="padding:5px;font-size:13px;background-color: #5592cb;width:100%;color:#fff;">'. $sInfo->name.'</span>',' ';
                                             }
                                             ?></h4>
                                         <p>Author : {{ $tBook->author }}</p>
                                         <p>Publication Year : {{ $tBook->year_of_publication }}</p>

                                         <?php
                                         $tBookIssueInfo = BookIssue::where('is_returned',0)->get();

                                         $issueCopy = [];

                                         foreach ($tBookIssueInfo as $issueIn){
                                             $issueCopy[] = $issueIn->copy_number;
                                         }

                                         $qr_string = json_decode($tBook->book['qr_string']);

                                         $is_available = 1;
                                         foreach ($qr_string as $qr_s){
                                             if (!in_array($qr_s, $issueCopy)) {

                                                 $is_available = 1;
                                             }
                                         }


                                         ?>

                                         <form action="{{ url('/print') }}" method="POST" class="side-by-side">
                                             {!! csrf_field() !!}
                                             <input type="hidden" name="id" value="{{ $tBook->id }}">
                                             <input type="hidden" name="title" value="{{ $tBook->title }}">
                                             <input type="hidden" name="author" value="{{ $tBook->author }}">
                                             <input type="hidden" name="type" value="{{ $tBook->type }}">
                                             <input type="hidden" name="cover_photo" value="{{ $tBook->cover_photo }}">
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

                    @else

                        <div class="alert alert-warning">
                            <strong>Sorry!</strong> No items selected in this section
                        </div>

                    @endif
                 </div>

             </div>
         </div>


         <div class="col-xs-12 col-sm-12 col-md-6">
             <div class="new_book">
                 <!-- Set up your HTML -->
                 <h2><span style="background-color: #5ad1d8;">Top Journals</span></h2>
                 <div class="owl-carousel">
                    @if( count( $topJournals ) )
                     @foreach ($topJournals as $tjournal)
                         <div>
                             <div class="thumbnail">
                                 <a href="{{ route('single.show',$tjournal->id) }}">
                                     <?php
                                     if( $tjournal->book['cover_photo'] != null){  ?>
                                     <img src="{{Request::root()}}/uploads/books/{{ $tjournal->cover_photo }}" alt="book">
                                     <?php } else { ?>
                                     <img src="{{ asset('default/blank-cover.png') }}" alt="book">
                                     <?php }?>


                                     <div class="caption">
                                         <p>{{ $tjournal->book['title'] }}</p>
                                         <p>Author : {{ $tjournal->book['author'] }}</p>
                                         <p>Publication Year : {{ $tjournal->book['year_of_publication'] }}</p>

                                         <?php

                                         $bookIssueInfo = BookIssue::where('is_returned',0)->get();

                                         $issueCopy = [];
                                         if( $bookIssueInfo ) {
                                             foreach ($bookIssueInfo as $issueIn){
                                                 $issueCopy[] = $issueIn->copy_number;
                                             }
                                         }

                                         $qr_string = json_decode($tjournal->book['qr_string']);

                                         $is_available = 1;
                                         if( $qr_string ) {
                                             foreach ($qr_string as $qr_s){
                                                 if (!in_array($qr_s, $issueCopy)) {

                                                     $is_available = 1;
                                                 }
                                             }
                                         }


                                         ?>

                                         <form action="{{ url('/print') }}" method="POST" class="side-by-side">
                                             {!! csrf_field() !!}
                                             <input type="hidden" name="id" value="{{ $tjournal->book['id'] }}">
                                             <input type="hidden" name="title" value="{{ $tjournal->book['title'] }}">
                                             <input type="hidden" name="author" value="{{ $tjournal->author }}">
                                             <input type="hidden" name="type" value="{{ $tjournal->book['type'] }}">
                                             <input type="hidden" name="cover_photo" value="{{ $tjournal->book['cover_photo'] }}">
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

                    @else

                        <div class="alert alert-warning">
                            <strong>Sorry!</strong> No items selected in this section
                        </div>

                    @endif
                 </div>

             </div>
         </div>
     </div>
 </div>
</section>

{{-- <div class="main-divider second-divider"></div> --}}

<section class="newSeminars" 4>
    <div class="container">
     <div class="row">
         <div class="col-xs-12 col-sm-12 col-md-12">
             <div class="new_book">
                 <!-- Set up your HTML -->
                 <h2><span style="background-color: #D5E5E6;">Seminar Proceeding</span></h2>

                 <div class="owl-carousel owl-carousel1">
                    @if( count( $seminars ) )
                     @foreach ($seminars as $seminar)
                         <div>
                             <div class="thumbnail">
                                 <a href="{{ route('single.show',$seminar->id) }}">
                                     <?php
                                     if( $seminar->cover_photo != null){  ?>
                                     <img src="{{Request::root()}}/uploads/books/{{ $seminar->cover_photo }}" alt="book">
                                     <?php } else { ?>
                                     <img src="{{ asset('default/blank-cover.png') }}" alt="book">
                                     <?php }?>


                                     <div class="caption">
                                         <p>{{ $seminar->title }}</p>

                                         <p>Publication Year : {{ $seminar->year_of_publication }}</p>

                                         <?php

                                         $bookIssueInfo = BookIssue::where('is_returned',0)->get();

                                         $issueCopy = [];

                                         foreach ($bookIssueInfo as $issueIn){
                                             $issueCopy[] = $issueIn->copy_number;
                                         }

                                         $qr_string = json_decode($seminar->qr_string);

                                         $is_available = 1;
                                         foreach ($qr_string as $qr_s){
                                             if (!in_array($qr_s, $issueCopy)) {

                                                 $is_available = 1;
                                             }
                                         }


                                         ?>


                                         <form action="{{ url('/print') }}" method="POST" class="side-by-side">
                                             {!! csrf_field() !!}
                                             <input type="hidden" name="id" value="{{ $seminar->id }}">
                                             <input type="hidden" name="title" value="{{ $seminar->title }}">
                                             <input type="hidden" name="author" value="{{ $seminar->author }}">
                                             <input type="hidden" name="type" value="{{ $seminar->type }}">
                                             <input type="hidden" name="cover_photo" value="{{ $seminar->cover_photo }}">
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

                    @else

                        <div class="alert alert-warning">
                            <strong>Sorry!</strong> No items found
                        </div>

                    @endif

                 </div>

             </div>
         </div>
     </div>
    </div>
</section>

@endsection

@section('ownjs')
    <script src="{{asset('/owlcarousel/owl.carousel.min.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('.owl-carousel1').owlCarousel({
                loop:true,
                margin:10,
                responsiveClass:true,
                responsive:{
                    0:{
                        items:1,
                        nav:true
                    },
                    600:{
                        items:3,
                        nav:false
                    },
                    1000:{
                        items:6,
                        nav:true,
                        loop:false
                    }
                }
            })


            $('.owl-carousel').owlCarousel({
                loop:true,
                margin:10,
                responsiveClass:true,
                responsive:{
                    0:{
                        items:1,
                        nav:true
                    },
                    600:{
                        items:3,
                        nav:false
                    },
                    1000:{
                        items:4,
                        nav:true,
                        loop:false
                    }
                }
            })
        });


</script>

@endsection
