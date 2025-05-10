@extends('frontend.app')

@section('owncss')

@endsection

@section('content_search')
    <div class="search_replace_for_contact">

    </div>
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
                <div class="single_book_title">
                    <h3>{{ $book->title }}</h3>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 single_thumbonail">
                <div class="thumbnail">

                    <?php
                    if( $book->cover_photo != null){  ?>
                    <img src="{{Request::root()}}/uploads/books/{{ $book->cover_photo }}" alt="book">
                    <?php } else { ?>
                     <img src="{{ asset('default/blank-cover.png') }}" alt="book">
                    <?php }?>
                    @if( Auth::user() )
                    <a href="{{ url('dashboard/library/' . $book->id . '/edit/?type=' . $book->type) }}" style="border: 1px solid #ddd;padding: 4px 28px;">Edit</a>
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-8">
                <div class="add_to_card_section">
                    <div class="details">
                        <p>{{ $book->title }} @if( $book->volume != null ) [{{ $item->volume }}] @endif</p>
                        @if( $book->type == 'book' )
                        <h4>Category : <?php
                            $category = json_decode($book->category);
                            foreach ($category as $sub){
                                $sInfo = Category::where('id',$sub)->first();
                                echo '<span style="background-color: #ee4157;" class="badge badge-light">'. $sInfo->name.'</span>',' ';
                            }
                            ?></h4>
                        @endif
                        <p>Type : {{ ucfirst( $book->type ) }}</p>
                        <?php
                        if($book->taggles != null){
                        ?>
                        <h5>Tag : <?php
                            $taggles = json_decode($book->taggles);
                            if( !empty( $taggles ) && is_array( $taggles )) :
                                foreach ( $taggles as $tag ){
                                    echo '<span style="background-color: #999999;" class="badge badge-light">'. $tag.'</span>',' ';
                                }
                            endif;
                            ?></h5>
                        <?php }?>

                        <p>Author : {{ $book->author }}</p>
                        <p>Publication Year : {{ $book->year_of_publication }}</p>
                        <p><strong>Bibliography : </strong> {{ $book->ibliography }}</p>

                        <table class="table table-striped table-bordered table-sm" style="max-width: 460px">
                            <thead>
                                <tr>
                                    <th>Copy #</th>
                                    <th>Availability</th>
                                    <th>Issue</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $copy = ( $book->copy ) ? $book->copy : 1;
                                for( $i = 1; $i <= $copy; $i++ ) :
                                    $qr_s = 'c-' . $i . '-' . $book->qr_string_unique;
                                    $bookIssueInfo = BookIssue::where('is_returned',0)->get();

                                    $issueCopy = [];

                                    foreach ($bookIssueInfo as $issueIn){
                                        $issueCopy[] = $issueIn->copy_number;
                                    }
                                ?>
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>
                                        @if (!in_array($qr_s, $issueCopy))
                                        Available
                                        @else
                                        Already Issued
                                        @endif
                                    </td>
                                    <td>
                                        @if (!in_array($qr_s, $issueCopy))
                                        <form action="{{ url('/print') }}" method="POST" class="side-by-side">
                                            {!! csrf_field() !!}
                                            <input type="hidden" name="id" value="{{ $book->id }}">
                                            <input type="hidden" name="title" value="{{ $book->title }}">
                                            <input type="hidden" name="author" value="{{ $book->author }}">
                                            <input type="hidden" name="type" value="{{ $book->type }}">

                                            <input type="submit" class="btn btn-success btn-sm" value="Add to Wishlist">
                                        @else
                                        <input type="button" class="btn btn-warning btn-sm" value="Already Issued">
                                        @endif
                                    </td>
                                </tr>
                            <?php endfor; ?>
                            </tbody>
                        </table>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('ownjs')

@endsection
