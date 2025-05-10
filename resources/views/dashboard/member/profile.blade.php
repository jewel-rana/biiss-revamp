@extends('master.app')

@section('content')

<!-- begin profile -->
			<div class="profile">
				<div class="profile-header">
					<!-- BEGIN profile-header-cover -->
					<div class="profile-header-cover"></div>
					<!-- END profile-header-cover -->
					<!-- BEGIN profile-header-content -->
					<div class="profile-header-content">
						<!-- BEGIN profile-header-img -->
						<div class="profile-header-img">
							<?php
							$photo = ( auth()->check() && $member->avatar != null ) ? 'uploads/profile/' . $member->avatar : 'default/avatar.png';
							?>
							<img src="{{ asset( $photo ) }}" alt="{{ $member->name }}">
						</div>
						<!-- END profile-header-img -->
						<!-- BEGIN profile-header-info -->
						<div class="profile-header-info">
							<h4 class="m-t-10 m-b-5">{{ $member->name }}</h4>
							<p class="m-b-10">{{ $member->title }}</p>
							<a href="{{ url('dashboard/member/' . $member->id . '/edit' ) }}" class="btn btn-xs btn-yellow">Edit Profile</a>
						</div>
						<!-- END profile-header-info -->
					</div>
					<!-- END profile-header-content -->
					<!-- BEGIN profile-header-tab -->
					<ul class="profile-header-tab nav nav-tabs">
						<li class="nav-item"><a href="#profile-about" class="nav-link @if( !isset( $_GET['tab'] ) ) active @endif" data-toggle="tab">ABOUT</a></li>
						<li class="nav-item"><a href="#profile-photos" class="nav-link" data-toggle="tab">PHOTOS</a></li>
						<li class="nav-item"><a href="#profile-history" class="nav-link @if( isset( $_GET['tab'] ) && $_GET['tab'] == 'history') active @endif" data-toggle="tab">ISSUE HISTORY</a></li>
					</ul>
					<!-- END profile-header-tab -->
				</div>
			</div>
			<!-- end profile -->

			<!-- begin profile-content -->
			<div class="profile-content">
				<!-- begin tab-content -->
				<div class="tab-content p-0">
					<!-- begin #profile-about tab -->
					<div class="tab-pane fade @if( !isset( $_GET['tab'] ) ) show active @endif" id="profile-about">
						<!-- begin table -->
						<div class="table-responsive">
							<table class="table table-profile">
								<thead>
									<tr>
										<th></th>
										<th>
											<h4>{{ $member->name }} <small>{{ $member->title }}</small></h4>
										</th>
									</tr>
								</thead>
								<tbody>
									<tr class="divider">
										<td colspan="2"></td>
									</tr>
									<tr>
										<td class="field">Mobile</td>
										<td><i class="fa fa-phone"></i> {{ $member->contact_number }}</td>
									</tr>
									<tr class="divider">
										<td colspan="2"></td>
									</tr>
									<tr class="highlight">
										<td class="field">Address</td>
										<td>
											{{ $member->address }}
										</td>
									</tr>
									<tr class="divider">
										<td colspan="2"></td>
									</tr>
									<tr>
										<td class="field">Email</td>
										<td>{{ $member->email }}</td>
									</tr>
									<tr class="divider">
										<td colspan="2"></td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- end table -->
					</div>
					<!-- end #profile-about tab -->
					<!-- begin #profile-photos tab -->
					<div class="tab-pane fade" id="profile-photos">
						<h4 class="m-t-0 m-b-20">Profile Photo</h4>
						<!-- begin superbox -->
						<div class="superbox " data-offset="50">
							<img src="{{ asset( $photo ) }}" alt="placeholder+image" style="width:auto; max-width: 260px;">
						</div>
						<!-- end superbox -->
					</div>
					<!-- end #profile-photos tab -->
					<!-- begin #profile-videos tab -->
					<div class="tab-pane fade  @if( isset( $_GET['tab'] ) && $_GET['tab'] == 'history' ) show active @endif" id="profile-history">
						<h4 class="m-t-0 m-b-20">ISSUED HISTORY</h4>
						<!-- begin row -->
						<div class="row row-space-2">
							<div class="table-responsive">
							@if( $issuedBooks->count() )
                            <table class="table table-bordered table-striped" id="example" style="width:100%;">
                            	<thead>
	                                <tr>
	                                    <th class="text-left">Name of Books</th>
	                                    <th>Status</th>
	                                    <th>Issued</th>
	                                    <th>Expire</th>
	                                </tr>
	                            </thead>
	                            <tbody>
	                                @foreach( $issuedBooks as $issue )
	                                <!-- {{ $issue->is_returned }} -->
	                                <tr>
	                                    <td class="text-left">
	                                        <a href="{{ url('dashboard/library/item/' . $issue->item_id) }}" target="ext">
	                                            {{ ucwords( $issue->item['title'] ) }}
	                                        </a>
	                                    </td>
	                                    <td>
	                                    @if( $issue->is_returned  )
	                                        <span style="background:green" class="badge badge-success">Returned</span>
	                                    @else
	                                        @if( $issue->end_date > date('Y-md') )
	                                            <span style="background:red" class="badge badge-danger">Expired</span>
	                                        @else
	                                            <span style="background:lightgreen;color:#465ddc;" class="badge badge-primary">Not returned</span>
	                                        @endif
	                                    @endif
	                                    </td>
	                                    <td>{{ $issue->start_date }}</td>
	                                    <td>{{ $issue->end_date }}</td>
	                                </tr>
	                            @endforeach
	                        	</tbody>
                            </table>
                            @else
                                <div class="alert alert-info col-sm-12">
                                    <strong>No issued books found.</strong>
                                </div>
                            @endif
                        </div>
						</div>
						<!-- end row -->
					</div>
					<!-- end #profile-history tab -->
				</div>
				<!-- end tab-content -->
			</div>
			<!-- end profile-content -->
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
$(document).ready(function() {
    var table = $('#example').DataTable( {
        "pageLength": 25,
        "bInfo": true,
        "searching": true,
        "lengthChange": true,
        "dom": 'Bfrtip',
        "buttons": [
            {
                extend: 'print',
                title: '{{ $member->name }} (<small>{{ $member->title }}</small>)',
                messageTop: '<h2>Issues History</h2>',
                exportOptions: {
                    columns: [ 1, 2, ':visible' ]
                },
                autoPrint: false,
                text: 'Print',
            },
            {
              extend: 'csvHtml5',
              exportOptions: {
                    columns: [ 0, 1, 2, 3 ],
                }
            },
            'colvis'
        ],
        select: {
            style: 'multi'
        },
        "columnDefs": [
            {"targets": [0], "searchable": false, "orderable": false, "visible": true},
            { "type": "num", "targets": 1 }
        ],
      "order": [[1, 'asc']]
    });

} );
</script>
@endsection
