@extends('frontend.app')

@section('owncss')
<style type="text/css">
    .paginate a{
        padding: 5px 8px;
        margin-right: 2px;
        border: 1px solid #337ab7;
    }
</style>
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
                <h2><span>Documents</span></h2>
                <div class="row">
                    <div class="paginate pull-right" style="padding-bottom:15px;">
                        <?php
                        for ($i = 65; $i <= 90; $i++) {
                            printf('<a href="'. route('front.documents', array_merge( Request::query(), array('letter_sort' => chr( $i ) ) ) ) . '" class="myclass">%1$s</a> ', chr($i));
                        } ?>
                    </div>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="width:60px;"><i class="fa fa-image"></i></th>
                                  <th>Title</th>
                                  <th>Author</th>
                                  <th>Subject</th>
                                  <th>Articles</th>
                                  <th>Year</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $books as $book )
                            <tr>
                                <td>
                                    @if( $book->cover_photo != '' )
                                    <img src="{{ asset($book->cover_photo) }}" class="img-responsive" style="width:60px;" alt="">
                                    @else
                                    <img src="{{ asset('default/cover/' . strtolower( $book->type ) . '.jpg') }}"  class="img-responsive" style="width:60px;">
                                    @endif
                                </td>
                                <td><a href="{{ url('/single/' . $book->id ) }}">{{ $book->title }}</a></td>
                                <td>
                                    <?php
                                    $articles = '';
                                    $subjects = '';
                                    if( $book->authors ) :
                                    foreach( $book->authors as $author ) :
                                        if( !empty( $author['author_name'] ) ) {
                                            echo '<span class="badge badge-info">' . $author['author_name'] . '</span>';
                                        }
                                        if( !empty( $author['auth_subject'] ) ) {
                                            if( !empty( $subjects ) ) {
                                                $subjects .= ', ';
                                            }
                                            $subjects .= $author['auth_subject'];
                                        }
                                        if( !empty( $author['author_article'] ) ) {
                                            if( !empty( $articles ) ) {
                                                $articles .= ', ';
                                            }
                                            $articles .= $author['author_article'];
                                        }
                                    endforeach;
                                    endif;
                                    ?>
                                </td>
                                <td>
                                    <?php echo $subjects; ?>
                                </td>
                                <td>
                                    <?php echo $articles; ?>
                                </td>
                                <td>{{ (int) $book->publication_year }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {!! $books->appends($_GET)->links() !!}
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
