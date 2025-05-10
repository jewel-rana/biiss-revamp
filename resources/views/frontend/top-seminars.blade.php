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
                <h2><span>Top Seminar Proceeding</span></h2>
                <div class="row">

                   @if( $items->count() > 0 )
                   @foreach( $items as $item )
                   @php
                      $bookPhoto = ( $item->item['cover_photo'] ) ? asset( $item->item['cover_photo'] ) : asset('/default/cover/' . strtolower( $item->type ) . '.jpg');
                   @endphp
                   <div class="col-md-3 mb-3">
                      <div class="flip-card">
                        <a href="{{ route('single.show', $item->book_id) }}">
                         <div class="flip-card-inner">
                            <div class="flip-card-front">
                               <img src="{{ $bookPhoto }}" class="img-fluid" alt="Avatar" style="width:100%;max-height:200px;min-height:200px;">
                               <div class="placeholder">
                                   <h4>{{ \Illuminate\Support\Str::words( $item->item['title'], $words = 5, $end = '...' ) }} [{{ ucfirst( $item->item['publication_year'] ) }}]</h4>
                               </div>
                            </div>
                            <div class="flip-card-back">
                               <h1>{{ \Illuminate\Support\Str::words( $item->item['title'], $words = 5, $end = '...' ) }}</h1>
                               <p>{{ $item->item['authormark'] }}</p><p>By -
                                 @if( count( $item->item['authors'] ) )
                                 @foreach( $item->item['authors'] as $author )
                                    <span class="badge badge-info">{{ $author->author_name }}</span>
                                 @endforeach
                                 @endif
                              </p>
                              <p>
                                 {{ strpos(strip_tags($item->item['bibliography']), 50) }}
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
                         <strong>Sorry!</strong> No seminars found.
                      </div>
                   </div>
                   @endif
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {{-- {!! $items->appends(Request::except('page'))->render() !!} --}}
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
