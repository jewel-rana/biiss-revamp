@extends('frontend.app')

@section('owncss')

@endsection

@section('content')

<div class="pageContent pt-4" 4>
    <div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="new_book">
                <!-- Set up your HTML -->
                <h2><span>New Books</span></h2>
                <div class="row">
                   @if( $books->count() > 0 )
                   @foreach( $books as $book )
                   @php
                      $bookPhoto = ( $book->item['cover_photo'] ) ? asset( $book->item['cover_photo'] ) : asset('/default/cover/' . strtolower( $book->item['type'] ) . '.jpg');
                   @endphp
                   <div class="col-md-3">
                      <div class="flip-card">
                        <a href="{{ route('single.show', $book->item['id']) }}">
                         <div class="flip-card-inner">
                            <div class="flip-card-front">
                               <img src="{{ $bookPhoto }}" class="img-fluid" alt="Avatar" style="width:100%;max-height:200px;min-height:200px;">
                               <div class="placeholder">
                                   <h4>{{ \Illuminate\Support\Str::words( $book->item['title'], $words = 5, $end = '...' ) }} [{{ ucfirst( $book->item['publication_year'] ) }}]</h4>
                               </div>
                            </div>
                            <div class="flip-card-back">
                               <h1>{{ \Illuminate\Support\Str::words( $book->item['title'], $words = 5, $end = '...' ) }}</h1>
                               <p>{{ $book->item['authormark'] }}</p>
                               @if( strtolower( $book->item['type'] ) == 'book')
                               <p>By -
                                 @if( count( $book->item['authors'] ) )
                                 @foreach( $book->item['authors'] as $author )
                                    <span class="badge badge-info">{{ $author->author_name }}</span>
                                 @endforeach
                                 @endif
                              </p>
                              <p>
                                 {{ strpos(strip_tags($book->item['bibliography']), 50) }}
                              </p>
                              @endif
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
                        {{-- {!! $books->appends(Request::except('page'))->render() !!} --}}
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
