@extends(config('theme.frontend').'::layouts.master')

@section('header')

@endsection
@section('content')
<section class="newitems" style="background: #D5E5E6;padding-bottom:45px;">
   <div class="container mb-5">
   <div class="row pb-5">
      <div class="col-xs-12 col-sm-12 col-md-12">
         <div class="new_book">
            <!-- Set up your HTML -->
            <h2><span style="background-color: #D5E5E6;">New Books</span></h2>
            <div class="row">
               @if( $books->count() > 0 )
               @foreach( $books as $nbook )
               @php
                  $nbookPhoto = ( $nbook->item['cover_photo'] ) ? asset( $nbook->item['cover_photo'] ) : asset('/default/cover/' . strtolower( $nbook->item['type'] ) . '.jpg');
               @endphp
               <div class="col-md-3 mb-3">
                  <div class="flip-card">
                     <a href="{{ route('single.show', $nbook->book_id) }}">
                        <div class="flip-card-inner">
                           <div class="flip-card-front">
                              <img src="{{ $nbookPhoto }}" class="img-fluid" alt="Avatar" style="width:100%;height:auto;">
                                  <div class="placeholder">
                                      <h4>{{ \Illuminate\Support\Str::words( $nbook->item['title'], $words = 5, $end = '...' ) }} [{{ ucfirst( $nbook->item['publication_year'] ) }}]</h4>
                                  </div>
                           </div>
                           <div class="flip-card-back">
                              <h1>{{ \Illuminate\Support\Str::words( $nbook->item['title'], $words = 5, $end = '...' ) }}</h1>
                              <!-- <p>{{ $nbook->item['authormark'] }}</p> -->
                              <p>By -
                                 @if( count( $nbook->item['authors'] ) )
                                 @foreach( $nbook->item['authors'] as $author )
                                    <span class="badge badge-info">{{ $author->author_name }}</span>
                                 @endforeach
                                 @endif
                              </p>
                              <p>
                                 {{ strpos(strip_tags($nbook->item['bibliography']), 160) }}
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
         </div>
      </div>
   </div>
</section>
{{--
<div class="main-divider first-divider"></div>
--}}
<section class="topItems" style="background: #5ad1d8;padding-bottom:45px;">
   <div class="container mb-5">
      <div class="row pb-5">
         <div class="col-xs-12 col-sm-12">
            <div class="new_book">
               <!-- Set up your HTML -->
               <h2><span style="background-color: #5ad1d8;">Top Books</span></h2>
               <div class="row">
                  @if( $featuredBooks->count() > 0 )
                  @foreach( $featuredBooks as $fbook )
                  @php
                     $fbookPhoto = ( $fbook->item['cover_photo'] ) ? asset( $fbook->item['cover_photo'] ) : asset('/default/cover/' . strtolower( $fbook->type ) . '.jpg');
                  @endphp
                  <div class="col-md-3">
                     <div class="flip-card">
                        <a href="{{ route('single.show', $fbook->book_id) }}">
                           <div class="flip-card-inner">
                              <div class="flip-card-front">
                                 <img src="{{ $fbookPhoto }}" alt="Avatar" style="width:100%;min-height:260px;height:auto;">
                                  <div class="placeholder">
                                      <h4>{{ \Illuminate\Support\Str::words( $fbook->item['title'], $words = 5, $end = '...' ) }} [{{ ucfirst( $fbook->item['publication_year'] ) }}]</h4>
                                  </div>
                              </div>
                              <div class="flip-card-back">
                                 <h1>{{ \Illuminate\Support\Str::words( $fbook->item['title'], $words = 5, $end = '...' ) }}</h1>
                                 <!-- <p>{{ $fbook->item['authormark'] }}</p> -->
                                 <p>By -
                                 @if( count( $fbook->item['authors'] ) )
                                 @foreach( $fbook->item['authors'] as $author )
                                    <span class="badge badge-info">{{ $author->author_name }}</span>
                                 @endforeach
                                 @endif
                              </p>
                              <p>
                                 {{ strpos(strip_tags($fbook->item['bibliography']), 160) }}
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
            </div>
         </div>
      </div>
   </div>
</section>
{{--
<div class="main-divider first-divider"></div>
--}}
<section class="topItems"  style="background: #D5E5E6;padding-bottom:45px;">
   <div class="container mb-5">
      <div class="row pb-5">
         <div class="col-xs-12 col-sm-12">
            <div class="new_book">
               <!-- Set up your HTML -->
               <h2><span style="background-color: #D5E5E6;">Top Journals</span></h2>
               <div class="row">
                  @if( $featuredJournals->count() > 0 )
                  @foreach( $featuredJournals as $fjournal )
                  @php
                     $fjournalPhoto = ( $fjournal->item['cover_photo'] ) ? asset( $fjournal->item['cover_photo'] ) : asset('/default/cover/' . strtolower( $fjournal->type ) . '.jpg');
                  @endphp
                  <div class="col-md-3">
                     <div class="flip-card">
                        <a href="{{ route('single.show', $fjournal->book_id) }}">
                           <div class="flip-card-inner">
                              <div class="flip-card-front">
                                 <img src="{{ $fjournalPhoto }}" alt="Avatar" style="width:100%;min-height:260px;height:auto;">
                                  <div class="placeholder">
                                      <h4>{{ \Illuminate\Support\Str::words( $fjournal->item['title'], $words = 5, $end = '...' ) }} [{{ $fjournal->item['item_number'] . ' - ' . $fjournal->item['publication_year'] }}]</h4>
                                  </div>
                              </div>
                              <div class="flip-card-back">
                                 <h1>{{ $fjournal->item['title'] }}</h1>
                                 <!-- <p>{{ $fjournal->item['authormark'] }}</p> -->
                                 <p>By -
                                 @if( count( $fjournal->item['authors'] ) )
                                 @foreach( $fjournal->item['authors'] as $author )
                                    <span class="badge badge-info" style="white-space: nowrap;">{{ $author['author_name'] }}</span>
                                 @endforeach
                                 @endif
                              </p>
                                 <p>Publisher - {{ \Illuminate\Support\Str::words( $fjournal->item['publisher'], $words = 5, $end = '...' ) }}</p>
                              </div>
                           </div>
                        </a>
                     </div>
                  </div>
                  @endforeach
                  @else
                  <div class="col-md-12">
                     <div class="alert alert-warning">
                        <strong>Sorry!</strong> No top journals found.
                     </div>
                  </div>
                  @endif
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
{{--
<div class="main-divider second-divider"></div>
--}}
<section class="newSeminars pb-5" style="background: #5ad1d8;padding-bottom:45px;">
   <div class="container mb-5">
      <div class="row pb-5">
         <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="new_book">
               <h2><span style="background-color: #5ad1d8;">Seminar Proceeding</span></h2>
               <div class="row">
                  @if( $featuredSeminars->count() > 0 )
                  @foreach( $featuredSeminars as $fseminar )
                  @php
                     $fseminarPhoto = ( $fseminar->item['cover_photo'] ) ? asset( $fseminar->item['cover_photo'] ) : asset('/default/cover/' . strtolower( $fseminar->type ) . '.jpg');
                  @endphp
                  <div class="col-md-3">
                     <div class="flip-card">
                        <a href="{{ route('single.show', $fseminar->book_id) }}">
                           <div class="flip-card-inner">
                              <div class="flip-card-front">
                                 <img src="{{ $fseminarPhoto }}" alt="Avatar" style="width:100%;min-height:260px;height:auto;">
                                  <div class="placeholder">
                                      <h4>{{ \Illuminate\Support\Str::words( $fseminar->item['title'], $words = 5, $end = '...' ) }}</h4>
                                  </div>
                              </div>
                              <div class="flip-card-back">
                                 <h1>{{ \Illuminate\Support\Str::words( $fseminar->item['title'], $words = 5, $end = '...' ) }}</h1>
                                 <!-- <p>{{ $fseminar->item['authormark'] }}</p> -->
                                 <p>Place - {{ $fseminar->item['place'] }}</p>
                                 <p>Date - {{ $fseminar->item['accession'] }}</p>
                              </div>
                           </div>
                        </a>
                     </div>
                  </div>
                  @endforeach
                  @else
                  <div class="col-md-12">
                     <div class="alert alert-warning">
                        <strong>Sorry!</strong> No top seminar found.
                     </div>
                  </div>
                  @endif
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
{{--
<div class="main-divider first-divider"></div>
--}}
<section class="topItems"  style="background: #5ad1d8;padding-bottom:45px;">
   <div class="container mb-5">
      <div class="row pb-5">
         <div class="col-xs-12 col-sm-12">
            <div class="new_book">
               <!-- Set up your HTML -->
               <h2><span style="background-color: #5ad1d8;">Top Magazines</span></h2>
               <div class="row">
                  @if( $featuredMagazins->count() > 0 )
                  @foreach( $featuredMagazins as $fmagazin )
                  @php
                     $fmagazinPhoto = ( $fmagazin->item['cover_photo'] ) ? asset( $fmagazin->item['cover_photo'] ) : asset('/default/cover/' . strtolower( $fmagazin->type ) . '.jpg');
                  @endphp
                  <div class="col-md-3">
                     <div class="flip-card">
                        <a href="{{ route('single.show', $fmagazin->book_id) }}">
                           <div class="flip-card-inner">
                              <div class="flip-card-front">
                                 <img src="{{ $fmagazinPhoto }}" alt="Avatar" style="width:100%;min-height:260px;height:auto;">
                                  <div class="placeholder">
                                      <h4>{{ \Illuminate\Support\Str::words( $fmagazin->item['title'], $words = 5, $end = '...' ) }} [{{ ucfirst( $fmagazin->item['publication_year'] ) }}]</h4>
                                  </div>
                              </div>
                              <div class="flip-card-back">
                                 <h1>{{ \Illuminate\Support\Str::words( $fmagazin->item['title'], $words = 5, $end = '...' ) }}</h1>
                                 <!-- <p>{{ $fmagazin->item['authormark'] }}</p> -->
                                 <p>Publisher - {{ $fmagazin->item['publisher'] }}</p>
                              </div>
                           </div>
                        </a>
                     </div>
                  </div>
                  @endforeach
                  @else
                  <div class="col-md-12">
                     <div class="alert alert-warning">
                        <strong>Sorry!</strong> No top magazines found.
                     </div>
                  </div>
                  @endif
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
@endsection
@section('footer')
@endsection
