@extends('master.modal')

@section('content')


				<form class="form-horizontal" method="POST" action="{{ route('login') }}">
				{{ csrf_field() }}
					<div class="form-group m-b-20">
						<input type="text" name="email" class="form-control form-control-lg inverse-mode" placeholder="Email Address" required />
					</div>
					<div class="form-group m-b-20">
						<input name="password" type="password" class="form-control form-control-lg inverse-mode" placeholder="Password" required />
					</div>
					<div class="login-buttons">
						<button type="submit" class="btn btn-primary btn-block btn-lg">Sign me in</button>
					</div>
				</form>

@endsection