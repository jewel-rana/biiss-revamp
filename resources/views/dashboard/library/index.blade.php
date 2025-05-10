@extends('master.app')
@section('owncss')
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/DataTables/css/jquery.dataTables.min.css') }}"/>

<style type="text/css">
.memberTitle {
    font-weight: bold;
    padding: 10px 5px 0;
    text-transform: uppercase;
    font-size: 18px;
}
.paginate {
    margin-top: 10px;
}
.paginate a{
    padding: 3px 5px;
    margin-right: 0px;
    border: 1px solid #99bede;
}
div.alphabet {
    position: relative;
    display: table;
    width: auto;
    margin-bottom: 0;
    float: right;
}
 
div.alphabet span {
    display: table-cell;
    color: #3174c7;
    cursor: pointer;
    text-align: center;
    width: auto;
    padding: 8px;
    font-size: 1.2rem;
}
 
div.alphabet span:hover {
    text-decoration: underline;
}
 
div.alphabet span.active {
    color: black;
}
 
div.alphabet span.empty {
    color: red;
}
 
div.alphabetInfo {
    display: block;
    position: absolute;
    background-color: #111;
    border-radius: 3px;
    color: white;
    top: 2em;
    height: 1.8em;
    padding-top: 0.4em;
    text-align: center;
    z-index: 1;
}
div.dataTables_wrapper div.dataTables_info {
    font-size: 15px;
    padding: 15px 0;
    font-weight: bold;
}
div.dataTables_wrapper div.dataTables_filter {
    display: none;
}
.dataTables_wrapper .dataTables_paginate .paginate_button {
  padding: inherit;
  margin-left: 0;
  margin-right: 0;
}
.dataTables_wrapper .dataTables_paginate .paginate_button:hover, .dataTables_wrapper .dataTables_paginate .paginate_button:focus {
  background: transparent;
  border: 0;
}

</style>
@endsection
@section('content')
    <!-- begin row -->
    <div class="row mb-3" id="customFilters">
      <div class="col-md-3 columns">
        <input id="start" type="text" class="form-control title" placeholder="Search by title" />
      </div>
      <div class="col-md-3 columns">
        <input id="end" type="text" class="form-control author" placeholder="Search by author" />
      </div>
      <div class="col-md-3 columns">
        <input id="end" type="text" class="form-control subject" placeholder="Search by subject" />
      </div>
      <div class="col-md-2 columns">
        <input id="end" type="text" class="form-control isbn" placeholder="Search by ISBN" />
      </div>
      <div class="col-md-1 columns">
        {{-- <button id="end" type="button" class="btn btn-primary btn-block">Filter</button> --}}
      </div>
    </div>
    <div class="row">
                <!-- begin col-12 -->
      <div class="col-md-12">
        <!-- begin result-container -->
        <div class="result-container">
          {{ Form::open(['route' => 'dashboard.library.print.qr','method'=>'POST', 'id' => 'qrPrintForm', 'target' => '_blank']) }}
          {{ @csrf_field() }}
          <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
            <button type="submit" class="btn btn-primary btn-sm">Prin QR</button>
            <div class="btn-group" role="group">
                <button id="btnGroupDrop1" type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Add new
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                  <a class="dropdown-item" href="{{ route('dashboard.library.create', ['type' => 'book']) }}"><i class="fa fa-plus"></i> Book</a>
                  <a class="dropdown-item" href="{{ route('dashboard.library.create', ['type' => 'journal']) }}"><i class="fa fa-plus"></i> Journal</a>
                  <a class="dropdown-item" href="{{ route('dashboard.library.create', ['type' => 'document']) }}"><i class="fa fa-plus"></i> Document / Magazine</a>
                </div>
            </div>
        </div>
<table id="example" class="dataTable1 display" style="width:100%">
        <thead>
            <tr>
                <th style="width:40px;">
                    <input type="checkbox" id="checkedall">
                </th>
                <th>Name</th>
                <th>Author</th>
                <th>Author Mark</th>
                <th>Subject / Category</th>
                <th>ISBN</th>
                <th>Call Number</th>
                <th></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th style="width:40px;">
                    <input type="checkbox" id="checkedall">
                </th>
                <th>Name</th>
                <th>Author</th>
                <th>Author Mark</th>
                <th>Subject / Category</th>
                <th>ISBN</th>
                <th>Call Number</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
          </form>
      </div>
  </div>
</div>


@endsection

@section('ownjs')
<script type="text/javascript" src="{{ asset('plugins/DataTables/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/DataTables/js/dataTables.bootstrap4.min.js') }}"></script>
<script language="javascript" type="text/javascript">
  var table;
  var customFilter = document.getElementById('customFilters');
var _alphabetSearch = '';
var alphabet;
var columnData;
var bins;
 
$.fn.DataTable.ext.search.push( function ( settings, searchData ) {
    if ( ! _alphabetSearch ) {
        return true;
    }
 
    if ( searchData[1].charAt(0) === _alphabetSearch ) {
        return true;
    }
 
    return false;
} );
 
 
function bin ( data ) {
    var letter, bins = {};
 
    for ( var i=0, ien=data.length ; i<ien ; i++ ) {
        letter = data[i].charAt(1).toUpperCase();
 
        if ( bins[letter] ) {
            bins[letter]++;
        }
        else {
            bins[letter] = 1;
        }
    }
 
    return bins;
}


  function deleteLibraryItem( id ) {
    var parent = $(this).parents('tr');
    var url = "{{ url('dashboard/library/delete/') }}/" + id;
    var data = null;

    var confirmed = confirm('Are you sure to delete this item?');

    if( confirmed ) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "DELETE",
            url: url,
            data: data,
            success: function(data, textStatus, xhr){
                if( data.success == true ) {
                    $(parent).remove();
                }

                return false;
            }
        });
    }

    return false;
  }

$(document).ready(function() {
    var table = $('#example').DataTable( {
        "processing": true,
        "pageLength": 25, 
        "bInfo": true,
        "searching": true,
        "lengthChange": true,
        "dom": '<"top"i>rt<"bottom"flp><"clear">',
        "ajax": '/ajax/get-all-items/?type={{ $type }}',
        "columns": [
            { "data": "checkboxes" },
            { "data": "title" },
            { "data": "authors" },
            { "data": "authormark" },
            { "data": "tags" },
            { "data": "isbn" },
            { "data": "call_number" },
            { "data": "action" }
        ],
        "columnDefs": [{"targets": [0], "searchable": false, "orderable": false, "visible": true}],
      "order": [[1, 'asc']]
    });

    // table.column(1).data();
    var alphabet = $('<div class="alphabet"/>').append( 'Search: ' );
    var columnData = table.column(1).data();
    bins = bin( columnData );
 
    $('<span class="clear active"/>')
        .data( 'letter', '' )
        .data( 'match-count', columnData.length )
        .html( 'None' )
        .appendTo( alphabet );
 
    for ( var i=0 ; i<26 ; i++ ) {
        var letter = String.fromCharCode( 65 + i );
 
        $('<span/>')
            .data( 'letter', letter )
            .data( 'match-count', bins[letter] || 0 )
            .addClass( ! bins[letter] ? 'empty' : '' )
            .html( letter )
            .appendTo( alphabet );
    }
 
    alphabet.insertBefore( table.table().container() );
 
    alphabet.on( 'click', 'span', function () {
        alphabet.find( '.active' ).removeClass( 'active' );
        $(this).addClass( 'active' );
 
        _alphabetSearch = $(this).data('letter');
        table.draw();
    } );
 
    var info = $('<div class="alphabetInfo"></div>')
        .appendTo( alphabet );
 
    alphabet
        .on( 'mouseenter', 'span', function () {
            info
                .css( {
                    opacity: 1,
                    left: $(this).position().left,
                    width: $(this).width()
                } )
                .html( $(this).data('match-count') );
        } )
        .on( 'mouseleave', 'span', function () {
            info.css('opacity', 0);
        } );
  //Custom Filters ( title search )
  $(customFilter).find('.title').keyup( function() {
    //search in the column "title" which index is 1
    table.columns(1).search( this.value ).draw();
  } );

  //Custom Filters ( Author search )
  $(customFilter).find('.author').keyup( function() {
    //search in the column "author" which index is 1
    table.columns(2).search( this.value ).draw();
  } );

  //Custom Filters ( Subject search )
  $(customFilter).find('.subject').keyup( function() {
    //search in the column "subject" which index is 1
    table.columns(3).search( this.value ).draw();
  } );

  //Custom Filters ( ISBN search )
  $(customFilter).find('.isbn').keyup( function() {
    //search in the column "ISBN" which index is 1
    table.columns(4).search( this.value ).draw();
  } );


  $('#qrPrintForm').submit(function( e ) {


            if( $( '#qrPrintForm input:checked').length > 0 ) {
                return true;
            }else {
                swal('Sorry!', 'No item selected.', "error");
                return false;
            }
        });
        //category search box display on click event
        $('#collapseCategory').on("click", function(e){
            e.defaultPrevented;

            $('#categoryFilter').toggleClass('hide');
        });

        //check all item
        $('#checkedall').on("click", function( e ) {
            e.defaultPrevented;

            var parent = $(this).parents('table');

            if( $(this).is(":checked") ) {
                $(parent).find(".itemcheckbox").each(function(){
                    $(this).prop('checked', true);
                });
            } else {
                $(parent).find(".itemcheckbox").each(function(){
                    $(this).prop('checked', false);
                });
            }
        });

} );
</script>

@endsection