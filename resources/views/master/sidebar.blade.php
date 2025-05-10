
		<!-- begin #sidebar -->
		<div id="sidebar" class="sidebar">
			<!-- begin sidebar scrollbar -->
			<div data-scrollbar="true" data-height="100%">
				<!-- begin sidebar user -->
				<ul class="nav">
					<li class="nav-profile">
						<a href="javascript:;" data-toggle="nav-profile">
							<div class="cover with-shadow"></div>
							<div class="image">
								<img src="{{ $photo }}" alt="" />
							</div>
							<div class="info">
								<b class="caret pull-right"></b>
								{{ auth()->user()->name ?? '' }}
								{{-- <small>Library Manager</small> --}}
							</div>
						</a>
					</li>
					<li>
						<ul class="nav nav-profile">
							{{-- <li><a href="{{ url('dashboard/member/profile') }}"><i class="fa fa-cog"></i> Profile</a></li> --}}
							{{-- <li><a href="{{ url('dashboard/member/change-password') }}"><i class="fa fa-pencil-alt"></i> Change Password</a></li> --}}
							<li><a href="{{ url('logout') }}"><i class="fa fa-question-circle"></i> Logout</a></li>
						</ul>
					</li>
				</ul>
				<!-- end sidebar user -->
				<!-- begin sidebar nav -->
				<ul class="nav">
					<li class="nav-header">
						<a href="{{ url('dashboard') }}">
							<span>Dashboard</span>
						</a>
					</li>
					<li class="has-sub @if(in_array( Request::segment(2), array('library', 'category')) ) active expand @endif">
						<a href="javascript:;">
							<b class="caret"></b>
							<i class="fa fa-hdd"></i>
							<span>Library</span>
						</a>
						<ul class="sub-menu" style="@if(in_array( Request::segment(2), array('library', 'category')) ) display:block @endif">
							<li><a href="{{ url('dashboard/library/?type=book') }}">Book</a></li>
							<li><a href="{{ url('dashboard/library/?type=journal') }}">Journal</a></li>
							<li><a href="{{ url('dashboard/library/?type=magazine') }}">Magazine</a></li>
							<li><a href="{{ url('dashboard/library/?type=document') }}">Document</a></li>
							<li><a href="{{ url('dashboard/library/?type=seminar') }}">Seminar Proceeding</a></li>
							<li><a href="{{ url('dashboard/category/') }}">Category</a></li>
							<li><a href="{{ url('dashboard/library/season') }}">Seasons</a></li>
						</ul>
					</li>
					<li class="has-sub @if(in_array( Request::segment(2), array('issue')) ) active expand @endif">
						<a href="javascript:;">
							<b class="caret"></b>
							<i class="fa fa-gem"></i>
							<span>Issues</span>
						</a>

						<ul class="sub-menu" style="@if(in_array( Request::segment(2), array('issue')) ) display: block @endif">
							<li>
								<a href="{{ url('dashboard/issue/create') }}">
									<i class="fa fa-plus text-theme m-l-5"></i>
									Create Issue
								</a></li>
							<li>
								<a href="{{ url('dashboard/issue') }}">
									<i class="fa fa-paper-plane text-theme m-l-5"></i>
									All Issue
								</a></li>
							<li>
								<a href="{{ url('dashboard/issue/?type=active') }}">
									<i class="fa fa-paper-plane text-theme m-l-5"></i>
								Active Issues
							</a></li>
							<li>
								<a href="{{ url('dashboard/issue/?type=expire') }}">
									<i class="fa fa-paper-plane text-theme m-l-5"></i>
									Expired Issues
								</a></li>
						</ul>
					</li>
					<li class="@if(in_array( Request::segment(2), array('return')) ) active  @endif">
						<a href="{{ url('dashboard/return') }}">
							<i class="fa fa-redo"></i>
							<span>Returns</span>
						</a>
					</li>
					<!--li class="@if(in_array( Request::segment(2), array('message')) ) active  @endif">
						<a href="{{ url('dashboard/message') }}">
							<i class="fa fa-envelope"></i>
							<span>Messages</span>
						</a>
					</li-->
					<li class="has-sub @if(in_array( Request::segment(2), array('member')) ) active expand @endif">
						<a href="javascript:;">
							<b class="caret"></b>
							<i class="fa fa-users"></i>
							<span>Members</span>
						</a>
						<ul class="sub-menu" style="@if(in_array( Request::segment(2), array('member')) ) display: block @endif">
							<li>
								<a href="{{ url('dashboard/member/create') }}">
									<i class="fa fa-plus"></i>
									Create member
								</a>
							</li>
							<li>
								<a href="{{ url('dashboard/member/') }}">
									<i class="fa fa-circle"></i>
									All Members
								</a>
							</li>
						</ul>
					</li>
					<li class="has-sub @if(in_array( Request::segment(2), array('feature')) ) active expand @endif">
						<a href="javascript:;">
							<b class="caret"></b>
							<i class="fa fa-list-alt"></i>
							<span>Featured</span>
						</a>
						<ul class="sub-menu" style="@if(in_array( Request::segment(2), array('feature')) ) display: block @endif">
							<li>
								<a href="{{ url('dashboard/feature/?type=new_book') }}">
									<i class="fa fa-book"></i>
									New Books
								</a>
							</li>
							<li>
								<a href="{{ url('dashboard/feature/?type=book') }}">
									<i class="fa fa-book"></i>
									Top Books
								</a>
							</li>
							<li>
								<a href="{{ url('dashboard/feature/?type=journal') }}">
									<i class="fa fa-book"></i>
									Top Journals
								</a>
							</li>
							<li>
								<a href="{{ url('dashboard/feature/?type=magazine') }}">
									<i class="fa fa-book"></i>
									Top Magazines
								</a>
							</li>
							{{-- <li>
								<a href="{{ url('dashboard/feature/?type=document') }}">
									<i class="fa fa-book"></i>
									Top Documents
								</a>
							</li> --}}
							<li>
								<a href="{{ url('dashboard/feature/?type=seminar') }}">
									<i class="fa fa-book"></i>
									Top Seminars
								</a>
							</li>
						</ul>
					</li>
					<li class="@if(in_array( Request::segment(2), array('banners')) ) active  @endif">
						<a href="{{ url('dashboard/banners') }}">
							<i class="fa fa-image"></i>
							<span>Banners</span>
						</a>
					</li>
					<li class="@if(in_array( Request::segment(2), array('roles')) ) active  @endif">
						<a href="{{ url('dashboard/roles') }}">
							<i class="fa fa-user-secret"></i>
							<span>Role Manager</span>
						</a>
					</li>
					<li>
						<a href="{{ url('logout') }}">
							<i class="fa fa-sign-out-alt"></i>
							<span>Logout</span>
						</a>
					</li>
					<!-- begin sidebar minify button -->
					<li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
					<!-- end sidebar minify button -->
				</ul>
				<!-- end sidebar nav -->
			</div>
			<!-- end sidebar scrollbar -->
		</div>
		<div class="sidebar-bg"></div>
		<!-- end #sidebar -->
