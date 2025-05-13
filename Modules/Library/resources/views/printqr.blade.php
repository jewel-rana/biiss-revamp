@extends('master.print')

@section('content')
<div class="print-head p-4 mt-5 text-center">
	<h1>{{ $title }}</h1><hr>
</div>
<div class="print-content">
	<table class="table table-striped table-condensed">
		<thead>
			<tr>
				<th>ACCNO</th>
				<th>CALLNO</th>
				<th>Item Information</th>
				<th>QR</th>
			</tr>
		</thead>
		<tbody>
			@if( $items->count() > 0 )
			@foreach( $items as $item )
			<tr>
				<td>{{ $item->acc_number }}</td>
				<td>{{ $item->call_number }}</td>
				<td>
					<strong>{{ $item->title }}</strong>
					<p>by 
						<em>
							@if( $item->type == 'book' )
								{{ $item->author }}
							@else
								{{ $item->publisher }}
							@endif
						</em>
					</p>
				</td>
				<td>
					@if( $item->copies )
					@foreach( $item->copies as $key => $copy )
                    <figure class="figure text-center">
	                    <img class="figure-img" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(80)->generate("' . $copy . '")) !!} ">
	                    <figcaption class="figure-caption">C-{{ $key + 1 }}</figcaption>
					</figure>
					@endforeach
                    @endif
				</td>
			</tr>
			@endforeach
			@else
			<tr>
				<td colspan="3">
					<div class="alert alert-info">
						<strong>Sorry! No Items Found.</strong>
					</div>
				</td>
			</tr>
			@endif
		</tbody>
	</table>

</div>

<button class="btn btn-default" id="printBtn">Print</button>
@endsection

@section('ownjs')
<script>
	jQuery( function( e ) {
		//onload print
		window.print();

		//button click event print
		$('#printBtn').on("click", function(e) {
			e.defaultPrevented;
			window.print();
		});
	});
</script>
@endsection