@extends("{$theme['default']}::layouts.master")

@section('owncss')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/color-admin-v4.2/admin/assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/awesomplete/awesomplete.css') }}">
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

        .paginate a {
            padding: 3px 5px;
            margin-right: 0px;
            border: 1px solid #99bede;
        }

    </style>
@endsection

@section('content')
    <!-- begin row -->
    <div class="row">
        <!-- begin col-3 -->
        <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-grey-darker">
                <div class="stats-icon"><i class="fa fa-book"></i></div>
                <div class="stats-info">
                    <h4>TOTAL ISSUES</h4>
                    <p>{{ $issues['total'] }}</p>
                </div>
                <div class="stats-link">
                    <a href="{{ url('dashboard/issue') }}">View All <i class="fa fa-arrow-alt-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-green">
                <div class="stats-icon"><i class="fa fa-book"></i></div>
                <div class="stats-info">
                    <h4>ACTIVE ISSUES</h4>
                    <p>{{ $issues['active'] }}</p>
                </div>
                <div class="stats-link">
                    <a href="{{ url('dashboard/issue/?type=active') }}">View All <i
                            class="fa fa-arrow-alt-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-red">
                <div class="stats-icon"><i class="fa fa-book"></i></div>
                <div class="stats-info">
                    <h4>EXPIRED ISSUES</h4>
                    <p>{{ $issues['expired'] }}</p>
                </div>
                <div class="stats-link">
                    <a href="{{ url('dashboard/issue/?type=expire') }}">View All <i
                            class="fa fa-arrow-alt-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-info">
                <div class="stats-icon"><i class="fa fa-users"></i></div>
                <div class="stats-info">
                    <h4>MEMBERS</h4>
                    <p>{{ $membercount }}</p>
                </div>
                <div class="stats-link">
                    <a href="{{ url('dashboard/member') }}">View All <i class="fa fa-arrow-alt-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- end col-3 -->
    </div>
    <!-- end row -->
    {{-- <div class="row">
        <div class="col-lg-12">
            <div class="result-container">
                {{ Form::open(['route' => 'dashboard.library.search', 'method' => 'GET']) }}
                <!-- begin input-group -->
                <div class="input-group input-group-lg m-b-20  home-search">
                    <input name="title" type="text" class="form-control input-white" placeholder="Search Title"
                        id="awesomTitle" />
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search fa-fw"></i> Search</button>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div> --}}
    <!-- begin row -->
    <div class="row">
        <!-- begin col-8 -->
        <div class="col-lg-8">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="index-1">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default"
                            data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning"
                            data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">Issue Analytics - last 7 days</h4>
                </div>
                <div class="panel-body">
                    <div id="interactive-chart" class="height-sm"></div>
                </div>
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-8 -->
        <!-- begin col-4 -->
        <div class="col-lg-4">

            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="index-7">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default"
                            data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning"
                            data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">Issue Statistics <span class="badge badge-info">{{ $issues['total'] }}</span>
                    </h4>
                </div>
                <div class="panel-body">
                    <div id="donut-chart" class="height-sm"></div>
                </div>
            </div>
            <!-- end panel -->

        </div>
        <!-- end col-4 -->
    </div>
    <!-- end row -->
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-lg-12">
            <ul class="nav nav-tabs">
                <li class="nav-items">
                    <a href="#default-tab-1" data-toggle="tab" class="nav-link active">
                        <span class="d-sm-none">Returns</span>
                        <span class="d-sm-block d-none">Returns (Last 7 days)</span>
                    </a>
                </li>
                <li class="nav-items">
                    <a href="#default-tab-2" data-toggle="tab" class="nav-link">
                        <span class="d-sm-none">Expired</span>
                        <span class="d-sm-block d-none">Issue Expired</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <!-- begin tab-pane -->
                <div class="tab-pane fade active show" id="default-tab-1">


                    <div class="m-b-10 f-s-10 m-t-10">
                        {{-- <h4 class="text-inverse">Book Returns - (Last Week)</h4>
                        --}}
                    </div>
                    <!-- begin widget-table -->
                    <div class="table-responsive">
                        <!-- begin widget-table -->
                        <table class="table table-bordered widget-table widget-table-rounded" data-id="widget">
                            <thead>
                            <tr>
                                <th width="1%"><i class="fa fa-image"></i></th>
                                <th>Title of the Book</th>
                                <th>Issued</th>
                                <th>Expired</th>
                                <th><i class="fa fa-cog"></i></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if ($weeklyReturns->count() > 0)
                                @foreach ($weeklyReturns as $return)
                                    @php
                                        $itemPhoto = ( $return->item['cover_photo'] ) ? asset( $return->item['cover_photo']
                                        ) : asset( 'default/cover/' . strtolower( $return->item['type'] ) . '.jpg');
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="widget-table-img"
                                                 style="background-image: url({{ $itemPhoto }});"></div>
                                        </td>
                                        <td>
                                            <h4 class="widget-table-title">
                                                <a href="{{ url('dashboard/library/item/' . $return->item['id']) }}"
                                                   target="_blank">
                                                    {{ $return->item['title'] }}
                                                </a>
                                            </h4>
                                            <p class="widget-table-desc m-b-15">{{ $return->item['author'] }}</p>
                                            {{-- <div
                                                class="progress progress-sm rounded-corner m-b-5">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-orange f-s-10 f-w-600"
                                                    style="width: 30%;">30%</div>
                                            </div> --}}
                                        </td>
                                        <td class="text-nowrap">
                                            {{ date('d/m/Y', strtotime($return->issue['start_date'])) }}
                                        </td>
                                        <td>{{ date('d/m/Y', strtotime($return->return_date)) }}</td>
                                        <td>
                                            <a href="{{ url('dashboard/return/view/' . $return->id) }}"
                                               class="btn btn-info btn-sm width-80 rounded-corner">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="alert alert-info">
                                        No items found.
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        <!-- end widget-table -->
                    </div>
                    <!-- end table-responsive -->
                </div>
                <!-- end tab-pane -->
                <!-- begin tab-pane -->
                <div class="tab-pane fade" id="default-tab-2">


                    <div class="m-b-10 f-s-10 m-t-10">
                        {{-- <h4 class="text-inverse">Issue Expired</h4>
                        --}}
                    </div>
                    <!-- begin widget-table -->
                    <div class="table-responsive">
                        <!-- begin widget-table -->
                        <table class="table table-bordered widget-table widget-table-rounded" data-id="widget">
                            <thead>
                            <tr>
                                <th width="1%"><i class="fa fa-image"></i></th>
                                <th>Title / Name</th>
                                <th>Member</th>
                                <th>Issued</th>
                                <th>Expire</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if ($expiredIssues->count() > 0)
                                @foreach ($expiredIssues as $issue)
                                    @php
                                        $itemPhoto = ( $issue->item?$issue->item['cover_photo']:'' ) ? asset( $issue->item?$issue->item['cover_photo']:'' )
                                        : asset( 'default/cover/' . strtolower( $issue->item?$issue->item['type']:'' ) . '.jpg');
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="widget-table-img" style="background-image: url({{ $itemPhoto }});"></div>
                                        </td>
                                        <td>
                                            <h4 class="widget-table-title">
                                                <a href="{{ url('dashboard/library/item/' . $issue->item_id) }}">
                                                    {{ $issue->item?$issue->item['title']:'' }}
                                                </a>
                                            </h4>
                                            <p class="widget-table-desc m-b-15">by -
                                                {{ $issue->item?ucwords($issue->item['author']):'' }}</p>
                                            {{-- <div
                                                class="progress progress-sm rounded-corner m-b-5">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-orange f-s-10 f-w-600"
                                                    style="width: 30%;">30%</div>
                                            </div> --}}
                                            <div class="clearfix f-s-10">
                                                Status:
                                                @if ($issue->end_date < date('Y-m-d'))
                                                    <b class="text-inverse" data-id="widget-elm"
                                                       data-light-class="text-inverse"
                                                       data-dark-class="text-white">Expired</b>
                                                @else
                                                    <b class="text-light" data-id="widget-elm"
                                                       data-light-class="text-light"
                                                       data-dark-class="text-white">Active</b>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-nowrap">
                                            <b class="text-inverse" data-id="widget-elm" data-light-class="text-inverse"
                                               data-dark-class="text-white">{{ $issue->user_name }}</b>
                                        </td>
                                        <td>{{ date('d/m/Y', strtotime($issue->start_date)) }}</td>
                                        <td>{{ date('d/m/Y', strtotime($issue->end_date)) }}</td>
                                        <td>
                                            <a href="#"
                                               class="btn btn-warning btn-sm width-80 rounded-corner takeReturn"
                                               id="{{ $issue->book_id }}"
                                               data-copy="{{ $issue->copy_number }}">Return</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="alert alert-info">
                                        No items found.
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        <!-- end widget-table -->
                    </div>
                    <!-- end table-responsive -->
                </div>
                <!-- end tab-pane -->
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
@endsection

@section('ownjs')
    <!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <script src="{{ asset('backend/color-admin-v4.2/admin/assets/plugins/flot/jquery.flot.min.js') }}"></script>
    <script src="{{ asset('backend/color-admin-v4.2/admin/assets/plugins/flot/jquery.flot.time.min.js') }}"></script>
    <script src="{{ asset('backend/color-admin-v4.2/admin/assets/plugins/flot/jquery.flot.resize.min.js') }}"></script>
    <script src="{{ asset('backend/color-admin-v4.2/admin/assets/plugins/flot/jquery.flot.pie.min.js') }}"></script>
    <script
        src="{{ asset('backend/color-admin-v4.2/admin/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}">
    </script>
    <script type="text/javascript" href="{{ asset('js/jquery-ui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/awesomplete/awesomplete.min.js') }}"></script>
    <script type="text/javascript"
        src="{{ asset('backend/color-admin-v4.2/admin/assets/plugins/bootstrap-sweetalert/sweetalert.min.js') }}"></script>
    <!-- ================== END PAGE LEVEL JS ================== -->
    <script>
		$(document).ready(function() {
		$('.takeReturn').on("click", function( e ) {
				var id = $(this).attr('id');
                var copy = $(this).attr('data-copy');
	            var parent = $(this).parents('#parent');

	            var confirmed = confirm('Are you sure to take return of this Item.');

	            if( confirmed == true ) {
					$.ajaxSetup({
						headers: {
		                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		                }
	            	});

	            	$.ajax({
		                type: "POST",
		                url: "{{ url('ajax/issueReturn') }}",
		                data: {id: id, copy: copy},
		                dataType: "json",
		                success: function( response ) {
		                    if( response.status == true ) {
		                    	$(parent).remove();
		                        swal("Success!", response.msg, "success");
		                    }else {
		                        swal("Sorry!", response.msg, "error");
		                    }
		                }
		            });
	            }

	            return false;
			});

	    var handleInteractiveChart = function() {
	        "use strict";

	        function a(a, e, i) {
	            $('<div id="tooltip" class="flot-tooltip">' + i + '</div>').css({
	                top: e - 45,
	                left: a - 55
	            }).appendTo("body").fadeIn(200)
	        }
	        if (0 !== $("#interactive-chart").length) {
	            var e = [
	            	@php
	            		foreach( $events as $key => $event ) :
	            			echo '[' . ($key + 1) . ',' .  $event['count'] .'],';
	            		endforeach;

	            	@endphp
	                ],
	                t = [
	                @php
	            		foreach( $events as $key => $event ) :
	            			echo '[' . ($key + 1) . ', "' .  $event['date'] .'"],';
	            		endforeach;

	            	@endphp
	                ];
	            $.plot($("#interactive-chart"), [{
	                data: e,
	                label: "Issues ",
	                color: COLOR_BLUE,
	                lines: {
	                    show: !0,
	                    fill: !1,
	                    lineWidth: 2
	                },
	                points: {
	                    show: !0,
	                    radius: 3,
	                    fillColor: COLOR_WHITE
	                },
	                shadowSize: 0
	            }], {
	                xaxis: {
	                    ticks: t,
	                    tickDecimals: 0,
	                    tickColor: COLOR_BLACK_TRANSPARENT_2
	                },
	                yaxis: {
	                    ticks: 10,
	                    tickColor: COLOR_BLACK_TRANSPARENT_2,
	                    min: 0,
	                    max: 200
	                },
	                grid: {
	                    hoverable: !0,
	                    clickable: !0,
	                    tickColor: COLOR_BLACK_TRANSPARENT_2,
	                    borderWidth: 1,
	                    backgroundColor: 'transparent',
	                    borderColor: COLOR_BLACK_TRANSPARENT_2
	                },
	                legend: {
	                    labelBoxBorderColor: COLOR_BLACK_TRANSPARENT_2,
	                    margin: 10,
	                    noColumns: 1,
	                    show: !0
	                }
	            });
	            var l = null;
	            $("#interactive-chart").bind("plothover", function(e, i, t) {
	                if ($("#x").text(i.x.toFixed(2)), $("#y").text(i.y.toFixed(2)), t) {
	                    if (l !== t.dataIndex) {
	                        l = t.dataIndex, $("#tooltip").remove();
	                        var n = t.datapoint[1].toFixed(2),
	                            o = t.series.label + " " + n;
	                        a(t.pageX, t.pageY, o)
	                    }
	                } else $("#tooltip").remove(), l = null;
	                e.preventDefault()
	            })
	        }
	    },
	    handleDonutChart = function() {
	        "use strict";
	        if (0 !== $("#donut-chart").length) {
	            var a = [{
	                label: "<a href='{{ url("dashboard/issue/?type=active") }}'>Active <span class='badge badge-info'>{{ $issues['active'] }}</span></a>",
	                data: {{ $issues['active'] }},
	                color: "#32a932"
	            }, {
	                label: "<a href='{{ url("dashboard/issue/?type=expire") }}'>Expired <span class='badge badge-info'>{{ $issues['expired'] }}</span></a>",
	                data: {{ $issues['expired'] }},
	                color: "#dc3545"
	            }];
	            $.plot("#donut-chart", a, {
	                series: {
	                    pie: {
	                        innerRadius: .5,
	                        show: !0,
	                        label: {
	                            show: !0
	                        }
	                    }
	                },
	                legend: {
	                    show: !0
	                }
	            })
	        }
	    },
	    handleDashboardDatepicker = function() {
	        "use strict";
	        $("#datepicker-inline").datepicker({
	            todayHighlight: !0
	        })
	    };

	    handleDonutChart();
	    handleInteractiveChart();
	    handleDashboardDatepicker();
	});

//autocomplete using awesomplete
addLoadListener(initAwesomplete);
addLoadListener(initAwesomAuthor);
addLoadListener(initAwesomCategory);

function initAwesomplete(){
  var input = document.getElementById("awesomTitle");
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

  });
}

function initAwesomAuthor(){
  var input = document.getElementById("awesomAuthor");
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


  });
}

function initAwesomCategory(){
  var input = document.getElementById("categoryFilter");
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
        xhr.open("GET", "{{ url('ajax/library/front/categorysuggestions') }}/" + value, true);
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
