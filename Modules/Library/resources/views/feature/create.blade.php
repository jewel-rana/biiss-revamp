@extends("{$theme['default']}::layouts.master")

@section('owncss')
<link rel="stylesheet" type="text/css" href="{{ asset('backend/color-admin-v4.2/admin/assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/awesomplete/awesomplete.css') }}">
<style type="text/css">
.memberTitle {
    font-weight: bold;
    padding: 10px 5px 0;
    text-transform: uppercase;
    font-size: 18px;
}
</style>

@endsection

@section('content')

            <!-- begin row -->
            <div class="row">
                <!-- begin col-12 -->
                <div class="col-md-12">
                    <!-- begin result-container -->
                    <div class="result-container">
                        <!-- begin dropdown -->
                        <div class="dropdown pull-left m-t-3 m-b-20">
                            <a href="javascript:;" class="btn btn-white btn-white-without-border dropdown-toggle" data-toggle="dropdown">
                            {{ ucfirst( str_replace( '_', ' ', $type ) ) }}
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('dashboard/feature/create?type=book') }}">Book</a></li>
                                <li><a href="{{ url('dashboard/feature/create?type=journal') }}">Journal</a></li>
                                <li><a href="{{ url('dashboard/feature/create?type=seminar') }}">Seminar</a></li>
                            </ul>
                        </div>
                        <div class="pull-left pl-3 m-t-3 m-b-20">
                          {{ Form::open(['url' => 'dashboard/feature/create', 'method' => 'GET']) }}
                            {{ Form::text('search', '', ['id' => 'awesomplete', 'class' => 'form-control input-white', 'style' => 'width:320px;', 'placeholder' => 'Search by Title, Author, Type']) }}
                            {{ Form::hidden('type', $type) }}
                            {{ Form::close() }}
                        </div>
                        <!-- end dropdown -->
                        <!-- begin pagination -->
                        <ul class="pull-right m-t-3 m-b-20">
                            {{ $items->appends($_GET)->links() }}
                        </ul>
                        <!-- end pagination -->
                        <!-- begin result-list -->
                        <ul class="result-list" id="searchResult">
                            @if( $items->count() > 0 )
                            @foreach( $items as $item )
                            <li>
                                <?php
                                $photo = ( $item->cover_photo == !null) ? asset( $item->cover_photo ) : asset('default/cover/' . strtolower( $item->type ) . '.jpg');
                                ?>
                                <a href="{{ route('library.show', $item->id ) }}" target="_blank" class="result-image" style="background-image: url({{ $photo }})"></a>
                                <div class="result-info">
                                    <h4 class="title">
                                        <a href="{{ route('library.show', $item->id ) }}" target="_blank">{{ $item->title }}</a>
                                    </h4>
                                    <p class="location">Author :
                                      @if( $item->authors )
                                      @foreach( $item->authors as $author )
                                        <span class="badge badge-info">{{ $author->author_name }}</span>
                                      @endforeach
                                      @endif
                                    </p>
                                    <p class="desc">
                                        <strong>Year: </strong>{{ $item->publication_year }}
                                    </p>
                                    <p class="desc">
                                        <strong>Month: </strong> {{ $item->month_of_publish }}
                                    </p>
                                    @if( $item->type == 'journal' )
                                    <p class="desc">
                                        <strong>VOL: </strong> {{ (!empty( $item->volume_number ) ) ? $item->volume_number : 'N/A' }} <strong>No: </strong> {{ $item->item_number }}
                                    </p>
                                    <p class="desc">
                                        <strong>Season: </strong> {{ (!empty( $item->season ) ) ? $item->season : 'N/A' }} <strong>FREQ: </strong> {{ $item->friq }}
                                    </p>
                                    @endif
                                    <p class="desc">
                                        {{ $item->description }}
                                    </p>
                                </div>

                                <div class="result-price">
                                  @if( empty( $item->featured ) )
                                    <a href="{{ url('dashboard/feature/add/' . $item->id . '/?type=' . $type ) }}" class="btn btn-info btn-block">Add to list</a>
                                  @else
                                  <button type="button" class="btn btn-default btn-block">Added to top list</button>
                                  @endif
                                </div>
                            </li>
                            @endforeach
                            @endif
                        </ul>
                        <!-- end result-list -->
                    </div>
                    <!-- end result-container -->
                </div>
                <!-- end col-12 -->
            </div>
            <!-- end row -->

@endsection

@section('ownjs')

<script type="text/javascript" src="{{ asset('plugins/awesomplete/awesomplete.min.js') }}"></script>
<script type="text/javascript">

// var autoComplete = window.document.getElementById('awesomplete');
//autocomplete using awesomplete
addLoadListener(initAwesomplete);

function initAwesomplete(){
  var input = document.getElementById("awesomplete");
  // var awesomplete = new Awesomplete(input);
  var value = input.value;

  var awesomplete = new Awesomplete(input, Awesomplete.FILTER_STARTSWITH);
  input.onkeyup = function(e){
    var code = (e.keyCode || e.which);

    if(code === 37 || code === 38 || code === 39 || code === 40 || code === 27 || code === 13){
      return false;
    }else{

      var xhr = getXHR();
      var value = this.value;
        xhr.open("GET", "{{ url('ajax/library/front/suggestions') }}/" + value + "/?type={{ str_replace( 'new_', '', $type ) }}", true);
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
