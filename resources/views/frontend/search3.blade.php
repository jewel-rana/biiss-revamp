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
                <h2><span>Search Books</span></h2>
                <div class="row">

                    @if( count( $items ) > 0 )

                        @foreach ($items as $item)
                            <div class="col-xs-12 col-sm-6 col-md-2">
                                <div class="thumbnail">
                                    <a href="{{ route('single.show',$item->id) }}">
                                        <?php
                                        if( $item->cover_photo != null){  ?>
                                        <img style="max-height: 300px; min-height: 300px" src="{{ asset( $item->cover_photo ) }}" alt="book">
                                        <?php } else { ?>
                                        <img src="{{ asset('default/cover/' . strtolower( $item->type ) . '.jpg') }}" alt="book">
                                        <?php }?>
                                        <div class="caption">
                                            <p>{{ $item->title }}
                                              @if( $item->volume != null )
                                              [{{ $item->volume }}]
                                              @endif
                                          </p>
                                            @if( $item->type == 'book')
                                            <h4><?php
                                                $category = json_decode($item->category);
                                                foreach ($category as $sub){
                                                    $sInfo = Category::where('id',$sub)->first();
                                                    echo '<div style="padding:5px;font-size:13px;background-color: #5592cb;width:100%;color:#fff;">'. $sInfo->name.'</span>',' ';
                                                }
                                                ?></h4>
                                              @endif
                                            <p>Type : {{ ucfirst( $item->type ) }}</p>
                                            <p>Author : {{ $item->author }}</p>
                                            <p>Publication Year : {{ $item->year_of_publication }}</p>

                                            <form action="{{ url('/print') }}" method="POST" class="side-by-side">
                                                {!! csrf_field() !!}
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <input type="hidden" name="title" value="{{ $item->title }}">
                                                <input type="hidden" name="author" value="{{ $item->author }}">
                                                <input type="hidden" name="type" value="{{ $item->type }}">
                                                <?php /*
                                                if($is_available == 1){
                                                ?>
                                                <input type="submit" class="btn btn-success btn-sm" value="Add to Wishlist">
                                                <?php } else {?>
                                                <input type="button" class="btn btn-warning btn-sm" value="Already Issued">
                                                <?php } */?>
                                            </form>

                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach

                    @else
                        <div class="alert alert-info">
                            <strong>Sorry! No items found.</strong>
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
