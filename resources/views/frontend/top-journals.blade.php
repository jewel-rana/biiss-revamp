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
                <h2><span>Top Journals</span></h2>
                <div class="row">
                   @if( $journals->count() > 0 )
                   @foreach( $journals as $journal )
                   @php
                      $journalPhoto = ( $journal->item['cover_photo'] ) ? asset( $journal->item['cover_photo'] ) : asset('/default/cover/' . strtolower( $journal->type ) . '.jpg');
                   @endphp
                   <div class="col-md-3 mb-3">
                      <div class="flip-card">
                        <a href="{{ route('single.show', $journal->book_id) }}">
                         <div class="flip-card-inner">
                            <div class="flip-card-front">
                               <img src="{{ $journalPhoto }}" class="img-fluid" alt="Avatar" style="width:100%;max-height:200px;min-height:200px;">
                               <div class="placeholder">
                                   <h4>{{ \Illuminate\Support\Str::words( $journal->item['title'], $words = 5, $end = '...' ) }} [{{ $journal->item['item_number'] . ' - ' . $journal->item['publication_year'] }}]</h4>
                               </div>
                            </div>
                            <div class="flip-card-back">
                               <h1>{!! \Illuminate\Support\Str::words($journal->item['title'], $words = 5, $end = '...')  !!}</h1>
                               <p>{{ $journal->item['authormark'] }}</p>
                                 <p>By -
                                 @if( count( $journal->item['authors'] ) )
                                 @foreach( $journal->item['authors'] as $author )
                                    <span class="badge badge-info">{{ $author->author_name }}</span>
                                 @endforeach
                                 @endif
                              </p>
                            </div>
                         </div>
                        </a>
                      </div>
                   </div>
                   @endforeach
                   @else
                   <div class="col-md-12">
                      <div class="alert alert-warning">
                         <strong>Sorry!</strong> No new books found.
                      </div>
                   </div>
                   @endif
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {!! $journals->appends(Request::except('page'))->render() !!}
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
