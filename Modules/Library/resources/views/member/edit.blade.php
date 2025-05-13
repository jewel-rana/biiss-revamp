@extends("{$theme['default']}::layouts.master")

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
							<img src="" alt="">
						</div>
						<!-- END profile-header-img -->
						<!-- BEGIN profile-header-info -->
						<div class="profile-header-info">
							<h4 class="m-t-10 m-b-5">{{ $member->name }}</h4>
							<p class="m-b-10">{{ $member->title }}</p>
							<a href="{{ url('dashboard/member/edit/' . $member->id ) }}" class="btn btn-xs btn-yellow">Edit Profile</a>
						</div>
						<!-- END profile-header-info -->
					</div>
					<!-- END profile-header-content -->
					<!-- BEGIN profile-header-tab -->
					<ul class="profile-header-tab nav nav-tabs">
						<li class="nav-item"><a href="#profile-about" class="nav-link active" data-toggle="tab">ABOUT</a></li>
						<li class="nav-item"><a href="#profile-photos" class="nav-link" data-toggle="tab">PHOTOS</a></li>
						<li class="nav-item"><a href="#profile-history" class="nav-link" data-toggle="tab">Issue History</a></li>
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
					<div class="tab-pane fade show active" id="profile-about">
						<!-- begin table -->
						<div class="table-responsive">
							<table class="table table-profile">
								<thead>
									<tr>
										<th></th>
										<th>
											<h4>Micheal	Meyer <small>Lorraine Stokes</small></h4>
										</th>
									</tr>
								</thead>
								<tbody>
									<tr class="highlight">
										<td class="field">Mood</td>
										<td><a href="javascript:;">Add Mood Message</a></td>
									</tr>
									<tr class="divider">
										<td colspan="2"></td>
									</tr>
									<tr>
										<td class="field">Mobile</td>
										<td><i class="fa fa-mobile fa-lg m-r-5"></i> +1-(847)- 367-8924 <a href="javascript:;" class="m-l-5">Edit</a></td>
									</tr>
									<tr>
										<td class="field">Home</td>
										<td><a href="javascript:;">Add Number</a></td>
									</tr>
									<tr>
										<td class="field">Office</td>
										<td><a href="javascript:;">Add Number</a></td>
									</tr>
									<tr class="divider">
										<td colspan="2"></td>
									</tr>
									<tr class="highlight">
										<td class="field">About Me</td>
										<td><a href="javascript:;">Add Description</a></td>
									</tr>
									<tr class="divider">
										<td colspan="2"></td>
									</tr>
									<tr>
										<td class="field">Country/Region</td>
										<td>
											<select class="form-control input-inline input-xs" name="region">
												<option value="US" selected>United State</option>
												<option value="AF">Afghanistan</option>
												<option value="AL">Albania</option>
												<option value="DZ">Algeria</option>
												<option value="AS">American Samoa</option>
												<option value="AD">Andorra</option>
												<option value="AO">Angola</option>
												<option value="AI">Anguilla</option>
												<option value="AQ">Antarctica</option>
												<option value="AG">Antigua and Barbuda</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="field">City</td>
										<td>Los Angeles</td>
									</tr>
									<tr>
										<td class="field">State</td>
										<td><a href="javascript:;">Add State</a></td>
									</tr>
									<tr>
										<td class="field">Website</td>
										<td><a href="javascript:;">Add Webpage</a></td>
									</tr>
									<tr>
										<td class="field">Gender</td>
										<td>
											<select class="form-control input-inline input-xs" name="gender">
												<option value="male">Male</option>
												<option value="female">Female</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="field">Birthdate</td>
										<td>
											<select class="form-control input-inline input-xs" name="day">
												<option value="04" selected>04</option>
											</select>
											-
											<select class="form-control input-inline input-xs" name="month">
												<option value="11" selected>11</option>
											</select>
											-
											<select class="form-control input-inline input-xs" name="year">
												<option value="1989" selected>1989</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="field">Language</td>
										<td>
											<select class="form-control input-inline input-xs" name="language">
												<option value="" selected>English</option>
											</select>
										</td>
									</tr>
									<tr class="divider">
										<td colspan="2"></td>
									</tr>
									<tr class="highlight">
										<td class="field">&nbsp;</td>
										<td class="p-t-10 p-b-10">
											<button type="submit" class="btn btn-primary width-150">Update</button>
											<button type="submit" class="btn btn-white btn-white-without-border width-150 m-l-5">Cancel</button>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- end table -->
					</div>
					<!-- end #profile-about tab -->
					<!-- begin #profile-photos tab -->
					<div class="tab-pane fade" id="profile-photos">
						<h4 class="m-t-0 m-b-20">Photos (70)</h4>
						<!-- begin superbox -->
						<div class="superbox " data-offset="50">
							<div class="superbox-list">
								<a href="javascript:;" class="superbox-img">
								<img data-img="../assets/img/gallery/gallery-1.jpg" />
								<span style="background: url(../assets/img/gallery/gallery-1-thumb.jpg);"></span>
								</a>
							</div>
							<div class="superbox-list">
								<a href="javascript:;" class="superbox-img">
								<img data-img="../assets/img/gallery/gallery-2.jpg" />
								<span style="background: url(../assets/img/gallery/gallery-2-thumb.jpg);"></span>
								</a>
							</div>
							<div class="superbox-list">
								<a href="javascript:;" class="superbox-img">
								<img data-img="../assets/img/gallery/gallery-3.jpg" />
								<span style="background: url(../assets/img/gallery/gallery-3-thumb.jpg);"></span>
								</a>
							</div>
						</div>
						<!-- end superbox -->
					</div>
					<!-- end #profile-photos tab -->
					<!-- begin #profile-videos tab -->
					<div class="tab-pane fade" id="profile-history">
						<h4 class="m-t-0 m-b-20">Videos (16)</h4>
						<!-- begin row -->
						<div class="row row-space-2">

						</div>
						<!-- end row -->
					</div>
					<!-- end #profile-history tab -->
				</div>
				<!-- end tab-content -->
			</div>
			<!-- end profile-content -->
@endsection
