@extends("{$theme['backend']}::layouts.master")

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
    top: 4em;
    height: 1.8em;
    padding-top: 0.4em;
    text-align: center;
    z-index: 1;
    min-width: 40px !important;
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
@media print
{
  html, body { height: auto; }
  #page-wrapper{ margin: 0 0 0 0; border-left:#FFF; padding: 0 10px; min-height:auto;}
  .navbar-static-side { margin: 0 0 0 0; margin-top: 10px;}
}

</style>
@endsection
@section('content')
    <!-- begin row -->
    <form id="filterForm">
    <div class="row mb-3" id="customFilters">
      <div class="col-md-2 columns mb-3">
        <input id="start" type="text" class="form-control accno" placeholder="ACCNO" />
      </div>
      <div class="col-md-2 columns mb-3">
        <input id="start" type="text" class="form-control author" placeholder="Author of Document" />
      </div>
      <div class="col-md-2 columns mb-3">
        <input id="start" type="text" class="form-control title" placeholder="Title" />
      </div>
      <div class="col-md-2 columns mb-3">
        <select id="end" class="form-control friq">
            <option value="">FREQ</option>
            <option>Daily</option>
            <option>Weekly</option>
            <option>Fortnightly</option>
            <option>Monthly</option>
            <option>Bi-Monthly</option>
            <option>Quarterly</option>
            <option>Annual</option>
            <option>Bi-Annual</option>
            <option>Series</option>
            <option>Others</option>
        </select>
      </div>
      <div class="col-md-2 columns mb-3">
        <input id="start" type="text" class="form-control volume" placeholder="VOL" />
      </div>
      <div class="col-md-2 columns mb-3">
        <input id="end" type="text" class="form-control number" placeholder="NO" />
      </div>
      <div class="col-md-2 columns mb-3">
        <input id="start" type="text" class="form-control month" placeholder="Month" />
      </div>
      <div class="col-md-2 columns mb-3">
          <select name="season" class="form-control season">
              <option value="">Season</option>
              @foreach($seasons as $key => $value)
                  <option value="{{ $key }}">{{ $value }}</option>
              @endforeach
          </select>
      </div>
      <div class="col-md-1 columns mb-3">
        <input id="minYear" type="text" class="form-control year" placeholder="Year from" />
      </div>
      <div class="col-md-1 columns mb-3">
        <input id="maxYear" type="text" class="form-control year" placeholder="Year to" />
      </div>
      <div class="col-md-2 columns mb-3">
        <input id="start" type="text" class="form-control isbn" placeholder="ISBN" />
      </div>
      <div class="col-md-2 columns mb-3">
        <input id="start" type="text" class="form-control issn" placeholder="ISSN" />
      </div>
      <div class="col-md-2 columns">
        <input id="start" type="text" class="form-control publisher" placeholder="Publisher" />
      </div>
      <div class="col-md-2 columns">
        <input id="start" type="text" class="form-control place" placeholder="Place" />
      </div>
      <div class="col-md-2 columns mb-3">
        <input id="start" type="text" class="form-control author_article" placeholder="Author of article" />
      </div>
      <div class="col-md-2 columns">
        <input id="start" type="text" class="form-control article" placeholder="Article" />
      </div>
      <div class="col-md-2 columns">
        <input id="start" type="text" class="form-control subjects" placeholder="Subject" />
      </div>
      <div class="col-md-2 columns">
        <input id="start" type="text" class="form-control source" placeholder="Source" />
      </div>
      <div class="col-md-2 columns">
        <input id="start" type="text" class="form-control from" placeholder="From" />
      </div>
      <div class="col-md-2 columns">
        <input id="start" type="text" class="form-control remarks" placeholder="Remarks" />
      </div>
      <div class="col-md-2 columns">
        <input id="min" type="text" class="form-control edate" placeholder="EDate from" />
      </div>
      <div class="col-md-2 columns">
        <input id="max" type="text" class="form-control edate" placeholder="EDate to" />
      </div>
      <div class="col-md-2 columns">
        <div class="btn-group">
          <!-- <button id="end" type="button" class="btn btn-primary search"><i class="fa fa-search"></i></button> -->
            <button type="button" class="btn btn-warning resetBtn"><i class="fa fa-times"></i></button>
        </div>
      </div>
    </div>
  </form>
    <div class="row">
                <!-- begin col-12 -->
      <div class="col-md-12">
        <!-- begin result-container -->
        <div class="result-container">

            <form action="{{ route('library.print.qr') }}" method="POST" id="qrPrintForm" target="_blank">
                @csrf
          <div class="btn-group mb-2" role="group" aria-label="Button group with nested dropdown">
            <button type="submit" class="btn btn-primary btn-sm">Print QR</button>
            <div class="btn-group" role="group">
                <button id="btnGroupDrop1" type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Add new
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                  <a class="dropdown-item" href="{{ route('library.create', ['type' => 'book']) }}" target="_blank"><i class="fa fa-plus"></i> Book</a>
                  <a class="dropdown-item" href="{{ route('library.create', ['type' => 'journal']) }}" target="_blank"><i class="fa fa-plus"></i> Journal</a>
                  <a class="dropdown-item" href="{{ route('library.create', ['type' => 'document']) }}" target="_blank"><i class="fa fa-plus"></i> Document</a>
                  <a class="dropdown-item" href="{{ route('library.create', ['type' => 'magazine']) }}" target="_blank"><i class="fa fa-plus"></i> Magazine</a>
                   <a class="dropdown-item" href="{{ route('library.create', ['type' => 'seminar']) }}" target="_blank"><i class="fa fa-plus"></i> Seminar</a>
                </div>
            </div>
        </div>
          <div class="btn-group mb-2" role="group" aria-label="Button group with nested dropdown pull-right">
            <div class="btn-group" role="group">
                <button id="btnGroupDrop1" type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  @php echo ( $type ) ? ucfirst( $type ) : 'Type'; @endphp
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                  <a class="dropdown-item" href="{{ route('library.index', ['type' => 'book']) }}"><i class="fa fa-circle-o"></i> Book</a>
                  <a class="dropdown-item" href="{{ route('library.index', ['type' => 'journal']) }}"><i class="fa fa-circle-o"></i> Journals</a>
                  <a class="dropdown-item" href="{{ route('library.index', ['type' => 'document']) }}"><i class="fa fa-circle-o"></i> Documents</a>
                  <a class="dropdown-item" href="{{ route('library.index', ['type' => 'magazine']) }}"><i class="fa fa-circle-o"></i> Magazines</a>
                  {{-- <a class="dropdown-item" href="{{ route('library.index', ['type' => 'seminar']) }}"><i class="fa fa-circle-o"></i> Seminars</a> --}}
                </div>
            </div>
        </div>
<table id="example" class="dataTable1 display" style="width:100%">
        <thead>
            <tr>
                <th><input type="checkbox" id="checkedall"></th>
                <th>ACCNO</th>
                <th>Document Author</th>
                <th>Title</th>
                <th>FREQ</th>
                <th>VOL</th>
                <th>NO.</th>
                <th>Month</th>
                <th>Season</th>
                <th>Year</th>
                <th>ISBN</th>
                <th>ISSN</th>
                <th>Publisher</th>
                <th>Place</th>
                <th>Author</th>
                <th>Article</th>
                <th>Subject</th>
                <th>Source</th>
                <th>From</th>
                <th>Remarks</th>
                <th>EDate</th>
                <th>Action</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th></th>
                <th>ACCNO</th>
                <th>Document Author</th>
                <th>Title</th>
                <th>FREQ</th>
                <th>VOL</th>
                <th>NO.</th>
                <th>Month</th>
                <th>Season</th>
                <th>Year</th>
                <th>ISBN</th>
                <th>ISSN</th>
                <th>Publisher</th>
                <th>Place</th>
                <th>Author</th>
                <th>Article</th>
                <th>Subject</th>
                <th>Source</th>
                <th>From</th>
                <th>Remarks</th>
                <th>EDate</th>
                <th>Action</th>
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
<script type="text/javascript" src="{{ asset('plugins/DataTables/js/dataTables.buttons.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/DataTables/js/buttons.print.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/DataTables/js/buttons.colVis.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/DataTables/js/dataTables.select.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/DataTables/js/buttons.html5.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/DataTables/js/pdfmake.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/DataTables/js/vfs_fonts.js') }}"></script>
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
        letter = data[i].charAt(0).toUpperCase();

        if ( bins[letter] ) {
            bins[letter]++;
        }
        else {
            bins[letter] = 1;
        }
    }

    return bins;
}

$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var min = parseInt( $('#minYear').val(), 10 );
        var max = parseInt( $('#maxYear').val(), 10 );
        var year = parseFloat( data[9] ); // use data for the year column
        // console.log(year);

        if ( ( isNaN( min ) && isNaN( max ) ) ||
             ( isNaN( min ) && year <= max ) ||
             ( min <= year   && isNaN( max ) ) ||
             ( min <= year   && year <= max ) )
        {
            return true;
        }
        return false;
    }
);

$.fn.dataTable.ext.search.push(
    function (settings, data, dataIndex) {
        var min = $('#min').datepicker("getDate");
        var max = $('#max').datepicker("getDate");

        var startDate = new Date(data[20]);
        // console.log(startDate);
        if (min == null && max == null) { return true; }
        if (min == null && startDate <= max) { return true;}
        if(max == null && startDate >= min) {return true;}
        if (startDate <= max && startDate >= min) { return true; }
        return false;
    }
);

$(document).ready(function() {
    var table = $('#example').DataTable( {
        "processing": true,
        "pageLength": 100,
        "bInfo": true,
        "searching": true,
        "lengthChange": true,
        "dom": '<"top"i>rt<"bottom"flp><"clear">',
        "dom": 'Bfrtip',
        "buttons": [
            {
                text: 'Deselect',
                action: function () {
                    table.rows().deselect();
                }
            },
            {
                extend: 'print',
                title: function() {
                  return "<div style='font-size:14px;text-align:center'>Bangladesh Institute of International and Strategic Studies (BIISS)</div>";
                },
                messageTop: '<div style="font-size:13px;text-align:center">Print Report : Documents</div>',
                exportOptions: {
                    columns: [ 1, 2, 3, ':visible' ]
                },
                autoPrint: true,
                text: 'Print',
                pageSize: 'A4',
                customize: function ( win ) {
                    $(win.document.body)
                        .css({'font-size': '10pt', 'padding':'50px 35px'});

                    $(win.document.body).find( 'table' )
                        .addClass( 'compact' )
                        .css({'font-size':'inherit', 'color':'#000'});

                    // $(win.document.body).find( 'table td' ).css('border', '1px solid #000');
                }
            },
            {
              extend: 'pdfHtml5',
               text: 'PDF',
               exportOptions: {
                  modifier: {
                     page: 'current'
                  }
               },
               header: true,
               title: 'Bangladesh Institute of International and Strategic Studies (BIISS)',
                messageTop: 'Print Report : Documents',
               orientation: 'portrate',
               customize: function(doc) {
                  doc.defaultStyle.fontSize = 8; //<-- set fontsize to 16 instead of 10
                  doc.styles.tableHeader.fontSize = 8;
                  doc.defaultStyle.alignment = 'center';
                  $(doc).find('h1').css('font-size', '8pt');
                  $(doc).find('h1').css('text-align', 'center');
               }
            },
            {
              extend: 'csvHtml5',
              exportOptions: {
                    columns: [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20],
                }
            },
            'colvis'
        ],
        select: {
            style: 'multi'
        },
        "ajax": {
            url:"{{ route('ajax.datatable.items', ['type' => $type]) }}",
            data:function (param){
                    param.accno =         $('.accno').val() || '0',
                    param.title =         $('.title').val() || '0',
                    param.friq =          $('.friq').val() || '0',
                    param.accession =     $('.accession').val() || '0',
                    param.volume_number = $('.volume').val() || '0',
                    param.item_number =   $('.number').val() || '0',
                    param.month =         $('.month').val() || '0',
                    param.minYear =       $('#minYear').val() || '0',
                    param.maxYear =       $('#maxYear').val() || '0',
                    param.issn =          $('.issn').val() || '0',
                    param.isbn =          $('.isbn').val() || '0',
                    param.publisher =     $('.publisher').val() || '0',
                    param.place =         $('.place').val() || '0',
                    param.author =        $('.author_article').val() || '0',
                    param.document_author = $('.author').val() || '0',
                    param.article =       $('.article').val() || '0',
                    param.subject =       $('.subject').val() || '0',
                    param.remarks =       $('.remarks').val() || '0',
                    param.min =           $('#min').val() || '0',
                    param.max =           $('#max').val() || '0'
                    param.source =         $('.source').val() || '0'
                    param.from =           $('.from').val() || '0'
                    param.season =           $('.season').val() || '0'

            }
        },
        "columns": [
            { mRender: function(data, type, row)
              {
                return '<input type="checkbox" name="id[]" value="' + row['id'] + '" class="itemcheckbox">';
              }
            },
            { "data": "acc_number" },
            { "data": "document_author" },
            { "data": "title" },
            { "data": "friq" },
            { "data": "volume_number" },
            { "data": "item_number" },
            { "data": "month_of_publish" },
            { "data": "season" },
            { "data": "publication_year" },
            { "data": "isbn" },
            { "data": "issn" },
            { "data": "publisher" },
            { "data": "place" },
            { "data": "authors" },
            { "data": "articles" },
            { "data": "subjects" },
            { "data": "source" },
            { "data": "from_where" },
            { "data": "remarks" },
            { "data": "edate" },
            { mRender: function(data, type, row)
              {
                var str = '<div class="btn-group">';
                str += '<a href="/dashboard/issue/create/' + row['id'] + '" onclick="addToplisted(' + row['id'] + ');" target="_blank" class="btn btn-success" target="_blank" id="' + row['id'] + '"><i class="fa fa-plus"></i> Issue</a>';
                str += '<a href="/dashboard/library/' + row['id'] + '" onclick="viewItem(' + row['id'] + ');" target="_blank" class="btn btn-primary" target="_blank" id="' + row['id'] + '"><i class="fa fa-eye"></i> View</a>';

                str += '<a href="/dashboard/library/' + row['id'] + '/edit" class="btn btn-success" target="_blank" id="' + row['id'] + '"><i class="fa fa-edit"></i> Edit</a>';

                str += '<a href="#" class="btn btn-danger deleteItem" id="' + row['id'] + '"><i class="fa fa-times"></i> Delete</a>';

                str += '</div>';

                return str;
              }
            }
        ],
        "columnDefs": [
            {"targets": [0,20], "searchable": false, "orderable": false, "visible": true},
            { "type": "num", "targets": 8 },
            { "type": "num", "targets": 5 }
        ],
      "order": [[1, 'asc']],
      "initComplete": function () {
            alphabetSearchStuff();
        }
    });

    function alphabetSearchStuff(){
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
    }

    //checkbox checked all selected rows
    $(table).find('tr.selected').each( function() {
      $(this).find('.itemcheckbox').prop('checked', true);
    });

    //select / deselect checkbox on click table row
    $('#example tbody').on('click', 'tr', function () {
        var checkbox = $(this).find('.itemcheckbox');
        //check selected or not
        if( $(this).hasClass('selected')) {
            $(checkbox).prop('checked', false);
        } else {
          //checked current item
          $(checkbox).prop("checked", true);
        }
    } );

    $('#example').on( 'click', '.deleteItem', function () {
      console.log( $(this) );
      var parent = $(this).parents('tr');
      var id = $(this).attr('id');
      var url = "{{ url('dashboard/library') }}/" + id;

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
              data: null,
              success: function(data, textStatus, xhr){
                  if( data.success == true ) {
                      table.row( parent ).remove().draw();
                  }

                  return false;
              }
          });
      }

      return false;
    } );

    // Event listener to the two range filtering inputs to redraw on input

    $("#min").datepicker({
      "dateFormat": "yy-mm-dd",
      onSelect: function () {
        table.draw();
      },
      changeMonth: true,
      changeYear: true,
      yearRange: '1945:'+(new Date).getFullYear()
    });
    $("#max").datepicker({
      "dateFormat": "yy-mm-dd",
      onSelect: function () {
        table.draw();
      },
      changeMonth: true,
      changeYear: true,
      yearRange: '1945:'+(new Date).getFullYear()
    });

    //reset filter
    $(document).on('click','.resetBtn',function (){
        $('#filterForm')[0].reset();
        table.ajax.reload();
    });

    $('#min, #max,.season,.friq').change(function () {
        table.ajax.reload();
    });
    // Event listener to the two range filtering inputs to redraw on input
    $(document).on('keyup','.accno,.title,.accession,.volume,.number,.month,#minYear,#maxYear,.isbn,.publisher,.place,.author,.article,.subject,.remarks,.source,.from,.author_article',function(){
        table.ajax.reload();
    });
    //check all item
    $('#checkedall').on("click", function( e ) {
        e.defaultPrevented;
        var parent = $(this).parents('table');

        if( $(this).is(":checked") ) {

          $(parent).find(".itemcheckbox").each(function(){
          $(this).prop('checked', true);

          //select datatable columns
          var dtparent = $(this).parents('tr');

          $(dtparent).addClass('selected');
        });
      } else {
        $(parent).find(".itemcheckbox").each(function(){
          $(this).prop('checked', false);

          //select datatable columns
          var dtparent = $(this).parents('tr');
          $(dtparent).removeClass('selected')
        });;
      }
    });
} );
</script>

@endsection
