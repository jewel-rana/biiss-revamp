@extends('frontend.app')

@section('owncss')
    <link rel="stylesheet" href="{{asset('/owlcarousel/assets/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('/owlcarousel/assets/owl.theme.default.min.css')}}">
@endsection

@section('content_search')

@endsection


@section('content')

<div class="pageContent pt-4" 4>
    <div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="new_book">
                <!-- Set up your HTML -->
                <h2><span>Search</span></h2>
                <div class="row">
                  <?php //dd( $items ); ?>
                   @if( $items->count() > 0 )
                   @foreach( $items as $item )
                   @php
                      $itemPhoto = ( $item->cover_photo ) ? asset( $item->cover_photo ) : asset('/default/cover/' . strtolower( $item->type ) . '.jpg');
                   @endphp
                   <div class="col-md-3 mb-3">
                      <div class="flip-card">
                        <a href="{{ route('single.show', $item->id) }}">
                         <div class="flip-card-inner">
                            <div class="flip-card-front">
                               <img src="{{ $itemPhoto }}" class="img-fluid" alt="Avatar" style="width:100%;max-height:200px;min-height:200px;">
                               <div class="placeholder">
                                   <h4>{{ \Illuminate\Support\Str::words( $item->title, $words = 5, $end = '...' ) }}
                                    @if( strtolower( $item->type ) == 'book' )
                                      [{{ ucfirst( $item->publication_year ) }}]
                                    @elseif( strtolower( $item->type ) == 'journal' )
                                      [{{ $item->item_number . ' - ' . $item->publication_year }}]
                                    @elseif( strtolower( $item->type ) == 'seminar')
                                      [{{ ucfirst( $item->volume ) }}]
                                    @else
                                      [{{ ucfirst( $item->publication_year ) }}]
                                    @endif
                                    </h4>
                               </div>
                            </div>
                            <div class="flip-card-back">
                               <h1>{{ \Illuminate\Support\Str::words( $item->title, $words = 5, $end = '...' ) }}</h1>
                               <p>{{ $item->authormark }}</p>
                               @if( in_array( strtolower( $item->type ), array('book', 'journal') ) )
                               <p>By -
                                 @if( count( $item->authors ) )
                                 @foreach( $item->authors as $author )
                                    <span class="badge badge-info">{{ $author['author_name'] }}</span>
                                 @endforeach
                                 @endif
                              </p>
                              <p>
                                 {{ strpos(strip_tags($item->bibliography), 50) }}
                              </p>
                              @else
                              <p>Publication Year - {{ $item->publication_year }}</p>
                              <p>Volume - {{ $item->volume_number }}</p>
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
                        {!! $items->appends(Request::except('page'))->render() !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
  </div>
</div>

@endsection

@section('ownjs')
    <script type="text/javascript" src="{{ asset('plugins/awesomplete/awesomplete.min.js') }}"></script>
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
                        items:5,
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

//carousel
addLoadListener(initAwesomplete);

function initAwesomplete(){
  var input = document.getElementById("librarySuggest");
  // var awesomplete = new Awesomplete(input);
  var value = input.value;

  var awesomplete = new Awesomplete(input);
  input.onkeyup = function(e){
    var code = (e.keyCode || e.which);

    if(code === 37 || code === 38 || code === 39 || code === 40 || code === 27 || code === 13){
      return false;
    }else{

      var xhr = getXHR();
      var value = this.value;
        xhr.open("GET", "{{ url('ajax/library/front/suggestions') }}/" + value, true);
        xhr.onreadystatechange = function()
        {
          if (xhr.readyState ==4)
          {
            if (xhr.status ==200 || xhr.status ==304)
            {
              // response = xhr.responseText; // or xhr.responseXML;

              var list = JSON.parse(xhr.responseText).map(function(i) { return i; });
              awesomplete.list = list;
                awesomplete.data = function(i, input){
                  return { label: i.level, value: i.value };
                }
            }
          }
        };
        xhr.send();

    }
  }

  input.addEventListener('awesomplete-selectcomplete', function(){

    // var xhr = new XMLHttpRequest();
    // xhr.open('GET', "{{ url('ajax/library/item') }}/" + this.value + "/?type=", true);
    // xhr.onreadystatechange = function()
    // {
    //   if(xhr.readyState == 4){
    //     if(xhr.status == 200 || xhr.status == 304)
    //     {
    //         $('.pagination').hide();
    //         document.getElementById("searchResult").innerHTML = xhr.response;
    //     }
    //   }
    // };
    // xhr.send();
  });
}

//carousel
addLoadListener(initAuthorAwesomplete);

function initAuthorAwesomplete(){
  var input = document.getElementById("authorSuggest");
  // var awesomplete = new Awesomplete(input);
  var value = input.value;

  var awesomplete = new Awesomplete(input);
  input.onkeyup = function(e){
    var code = (e.keyCode || e.which);

    if(code === 37 || code === 38 || code === 39 || code === 40 || code === 27 || code === 13){
      return false;
    }else{

      var xhr = getXHR();
      var value = this.value;
        xhr.open("GET", "{{ url('ajax/library/front/authorsuggestions') }}/" + value, true);
        xhr.onreadystatechange = function()
        {
          if (xhr.readyState ==4)
          {
            if (xhr.status ==200 || xhr.status ==304)
            {
              // response = xhr.responseText; // or xhr.responseXML;

              var list = JSON.parse(xhr.responseText).map(function(i) { return i; });
              awesomplete.list = list;
                awesomplete.data = function(i, input){
                  return { label: i.level, value: i.value };
                }
            }
          }
        };
        xhr.send();

    }
  }

  input.addEventListener('awesomplete-selectcomplete', function(){

    // var xhr = new XMLHttpRequest();
    // xhr.open('GET', "{{ url('ajax/library/item') }}/" + this.value + "/?type=", true);
    // xhr.onreadystatechange = function()
    // {
    //   if(xhr.readyState == 4){
    //     if(xhr.status == 200 || xhr.status == 304)
    //     {
    //         $('.pagination').hide();
    //         document.getElementById("searchResult").innerHTML = xhr.response;
    //     }
    //   }
    // };
    // xhr.send();
  });
}

function getXHR(){
  //ajax request
  var xhr;
  try {
    xhr = new XMLHttpRequest();
  } catch (error)
  {
    try
    {
      xhr = new ActiveXObject('Microsoft.XMLHTTP');
    } catch (error)
    {
      xhr = null;
    }
  }
  return xhr;
}

//Load Listener
function addLoadListener(fn)
{
  if(typeof window.addEventListener != 'undefined')
  {
    window.addEventListener('load', fn, false);
  }
  else if(typeof document.addEventListener != 'undefined')
  {
    document.addEventListener('load', fn, false);
  }
  else if(typeof window.attachEvent != 'undefined')
  {
    window.attachEvent('onload', fn);
  }
  else
  {
    var oldfn = window.onload;
    if (typeof window.onload != 'function')
    {
      window.onload = fn;
    }
    else
    {
      window.onload = function()
      {
        oldfn();
        fn();
      };
    }
  }
}
</script>

@endsection
