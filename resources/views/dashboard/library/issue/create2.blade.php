@extends('master.app')

@section('owncss')
<link rel="stylesheet" href="{{asset('/date/jquery.datetimepicker.css') }}" />
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
                        <!-- begin input-group -->
                        <div class="input-group input-group-lg m-b-20">
                            <input type="text" id="librarySuggest" name="search" class="col-ms-6 form-control input-white mr-2" style="padding: 22px 10px;font-size: 16px;width: 420px;" placeholder="Search by Title, Author, Publisher..." />
                            <input type="text" id="qrCode" name="search" class="form-control input-white ml-2 mr-2" placeholder="QR Scan here" />
                            
                        </div>
                        <!-- end input-group -->
                        <hr>

                         {{ Form::open(['url' => '', 'method' => 'POST', 'id' => 'submitIssueForm']) }}
                        <div class="row" id="issueFormParent">
                            <div class="col-md-2">
                                @php
                                if( isset( $stock ) )
                                    $photo = ( $stock->item['cover_photo'] ) ? asset( $stock->item['cover_photo'] ) : asset('default/cover/' . strtolower( $stock->item['type'] ) . '.jpg');
                                else :

                                endif;
                                @endphp
                                <img src="{{ $photo }}" id="coverPhoto" class="img-fluid" alt="placeholder+image">
                                <input type="hidden" name="book_id" value="@if( !empty( $stock ) ) {{ $stock->id }} @endif" id="itemId">
                            </div>
                            <div class="col-md-4 basicInfo">
                                <h4>Basic Information</h4>
                                <table class="table table-condensed">
                                    <tbody>
                                        <tr>
                                            <th>Title</th>
                                            <td>
                                                <span id="itemTitle">@if( !empty( $stock ) ) {{ $stock->item['title'] }} @endif</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Type</th>
                                            <td>
                                                <span id="itemType">@if( !empty( $stock ) ) {{ $stock->item['type'] }} @endif</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Authors</th>
                                            <td id="itemAuthor">
                                                @if( !empty( $stock ) )
                                                @foreach( $stock->item['authors'] as $author )
                                                    <span class="badge badge-info">{{ $author->author_name }}</span>
                                                @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Publisher</th>
                                            <td>
                                                @if( !empty( $stock ) )
                                                    {{ $stock->item['publisher'] }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Publish Date</th>
                                            <td>
                                                <span id="itemPublishDate">@if( !empty( $stock ) ) {{ $stock->item['accession'] }} @endif</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Publication Year</th>
                                            <td>
                                                <span id="itemPublishDate">@if( !empty( $stock ) ) {{ $stock->item['publication_year'] }} @endif</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Call Number</th>
                                            <td>
                                                <span id="itemSelf">@if( !empty( $stock ) ) {{ $stock->item['call_number'] }} @endif</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>ACCNO</th>
                                            <td>
                                                <span id="itemSelf">@if( !empty( $stock ) ) {{ $stock->item['acc_number'] }} @endif</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>ISBN</th>
                                            <td>
                                                <span id="itemSelf">@if( !empty( $stock ) ) {{ $stock->item['isbn'] }} @endif</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Self</th>
                                            <td>
                                                <span id="itemSelf">@if( !empty( $stock ) ) {{ $stock->item['self'] }} @endif</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Rack</th>
                                            <td>
                                                <span id="itemRak">@if( !empty( $stock ) ) {{ $stock->item['rack'] }} @endif</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3 issueInfo">
                                <h4>Issue Settings</h4>

                                <div class="form-group">
                                    <label>Select Copy</label>
                                    <select class="form-control" id="copySelect" name="copy_number"  required="true">
                                        @if( $stock && $stock->item['copies']->count() > 0 )
                                            <option value="">Select Copy</option>
                                        @foreach( $stock->item['copies'] as $cpy )
                                            @if( ! $cpy->issued )
                                            <option value="{{ $cpy->id }}">{{ $cpy->copy_number }}</option>
                                            @endif
                                        @endforeach
                                        @else
                                            <option value="">Select Copy</option>
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Issue Date</label>
                                    <input type="text" name="issueDate" id="datetimepicker_join" value="{{ date('Y-m-d') }}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Issue Days (<small>Total Days to Issue</small>)</label>
                                    <input type="text" name="issueDays" placeholder="Exmple: 5" class="form-control" required="true">
                                </div>

                                <div class="form-group">
                                    <button type="submit" name="submit" class="btn btn-primary btn-block" id="submitIssue">Save Issue</button>
                                </div>

                                
                            </div>
                            <div class="col-md-3 memberInfo">
                                <div class="form-group">
                                    <label>Member ID (Assign to Member)</label><br>
                                    <input type="text" name="member_id" id="memberSuggest" class="form-control" placeholder="Member Name or ID" required="true">
                                    <div id="mInfo">
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        {{ Form::close() }}
                    </div>
                    <!-- end result-container -->
                </div>
                <!-- end col-12 -->
            </div>
            <!-- end row -->


                            <!-- #modal-alert -->
                            <div class="modal fade" id="modal-alert">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Alert Header</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-danger m-b-0">
                                                <h5><i class="fa fa-info-circle"></i> Alert Header</h5>
                                                <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Close</a>
                                            <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Action</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

@endsection

@section('ownjs')

<script type="text/javascript" href="{{ asset('js/jquery-ui.js') }}"></script>  <script src="{{asset('/date/jquery.datetimepicker.full.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/awesomplete/awesomplete.min.js') }}"></script>
<script type="text/javascript" src="{{  asset('backend/color-admin-v4.2/admin/assets/plugins/bootstrap-sweetalert/sweetalert.min.js') }}"></script>
<script type="text/javascript">
    jQuery( function() {
        $( "#datetimepicker_join" ).datepicker({ dateFormat: 'yy-mm-dd' });
      $( "#datetimepicker_confirmation" ).datepicker({ dateFormat: 'yy-mm-dd' });
        //QR Scan Event
        $('#qrCode').on("change", function(e){
            var element = $(this);
            var qr = $(this).val();

            populateQrScan( qr, element );
            
        });

        //submit Issue
        $('#submitIssueForm').on("submit", function( e ) {
            e.defaultPrevented;

            $.ajaxSetup({

            });

            $.ajax({
                type: "POST",
                url: "{{ url('ajax/createIssue') }}",
                data: $(this).serialize(),
                dataType: "json",
                success: function( response ) {
                    if( response.status == true ) {
                        swal({
                            title: "Success!", 
                            text: response.msg, 
                            type: "success",
                        }).then((willDelete) =>{
                            window.location.href = "{{ url('dashboard/issue/?type=active') }}";
                       });
                        
                    }else {
                        swal("Sorry!", response.msg, "error");
                    }
                }
            });

            return false;
        });

        $('.swal-button--confirm').on("click", function() {
            window.location.href = "{{ url('dashboard/issue/?type=active') }}";
        });
    });

    //autocomplete using awesomplete
    addLoadListener(initAwesomplete);

    //awesomeplete for Book Search
    function initAwesomplete(){
        var input = document.getElementById("librarySuggest");
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
                xhr.open("GET", "{{ url('ajax/library/suggestions') }}/" + value, true);
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
            input.addEventListener("awesomplete-select", function(event) {
                this.setAttribute('data-label', event.text.label );
                // console.log( event.text.label, event.text.value );
            });

          input.addEventListener('awesomplete-selectcomplete', function() {
            var itemID = this.value;
            this.value = this.getAttribute('data-label');
            var xhr = new XMLHttpRequest();
            xhr.open('GET', "{{ url('ajax/library/single') }}/" + itemID, true);
            xhr.responseType = 'json';
            xhr.onreadystatechange = function()
            {
              if(xhr.readyState == 4){
                if(xhr.status == 200 || xhr.status == 304)
                {
                    var parent = document.getElementById('issueFormParent');
                    var data = xhr.response;
                    formatData( data, parent );
                }
              }
            };
            xhr.send();
        });
    }

    //autocomplete using awesomplete
    addLoadListener(initAwesompleteMember);

    //awesomeplete for Book Search
    function initAwesompleteMember(){
        var input = document.getElementById("memberSuggest");
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
                xhr.open("GET", "{{ url('ajax/member/suggestions') }}/" + value, true);
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

          input.addEventListener('awesomplete-selectcomplete', function() {

            var xhr = new XMLHttpRequest();
            xhr.open('GET', "{{ url('ajax/member/single') }}/" + this.value, true);
            xhr.responseType = 'json';
            xhr.onreadystatechange = function()
            {
              if(xhr.readyState == 4){
                if(xhr.status == 200 || xhr.status == 304)
                {
                    var data = xhr.response;
                    var info = document.getElementById('mInfo');
                    info.innerHTML = "";
                    var span = document.createElement( 'p' );
                    span.className = 'memberTitle';
                    span.appendChild( document.createTextNode( data.name ) );
                    info.appendChild(span);

                    var img = document.createElement('img');
                    var src = ( data.avatar != '' ) ? data.avatar : '';
                    img.className = 'img-thumbnail img-fluid';
                    img.src = "{{ asset('uploads/profile') }}/" + src;
                    info.appendChild( img );
                }
              }
            };
            xhr.send();
        });
    }

    function populateQrScan( qr, element ) {
        var qrString = qr.replace(/(^[a-zA-Z][-][\d][-])/, '');
        var parent = document.getElementById('issueFormParent');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        if(qrString) {
            $.ajax({
                url: '{{Request::root()}}/dashboard/get_data_by_qr_string/ajax/' + qrString,
                type: "GET",
                dataType: "json",
                success:function(data) {

                    formatData( data, parent );

                }
            });
        }
    }

    function formatData( data, parent ) {
        if( data.id ) {
            parent.querySelector('#itemId').value = data.id;
            parent.querySelector('#itemTitle').appendChild( document.createTextNode( data.title ) );
            parent.querySelector('#itemAuthor').appendChild( document.createTextNode( data.author ) );
            parent.querySelector('#itemType').appendChild( document.createTextNode( data.type ) );
            parent.querySelector('#itemPublisher').appendChild( document.createTextNode( data.publisher ) );
            parent.querySelector('#itemPublishDate').appendChild( document.createTextNode( data.year_of_publication ) );
            parent.querySelector('#itemSelf').appendChild( document.createTextNode( data.self ) );
            parent.querySelector('#itemRak').appendChild( document.createTextNode( data.rack ) );

            //set coverphoto
            if( data.cover_photo != '' ) {
                parent.querySelector('#coverPhoto').setAttribute('src', '{{ Request::root() . '/uploads/books/' }}/' + data.cover_photo );
            }

            //set copy in the select box
            // var copynumber = ( data.copy ) ? data.copy : 1;
            $('#copySelect').find('option').remove();
            for( var i = 0; i < data.copiesAvailable.length; i++ ) {
   
                $('#copySelect').append($('<option>', {
                    value: data.copiesAvailable[i],
                    text : data.copiesAvailable[i]
                }));
                
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