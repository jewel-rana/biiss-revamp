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
                        <?php
                        $photo = (auth()->check() && auth()->user()->avatar != null) ? asset('uploads/profile/' . auth()->user()->avatar) : asset('default/avatar.png');
                        ?>
                        <img src="{{ $photo }}" alt=""/>
                    </div>
                    <div class="info">
                        <b class="caret pull-right"></b>
                        {{ auth()->user()->name ?? '' }}
                        <small>Library Manager</small>
                    </div>
                </a>
            </li>
            <li>
                <ul class="nav nav-profile">
                    <li><a href="{{ route('auth.profile') }}"><i class="fa fa-cog"></i> Profile</a></li>
                    <li><a href="{{ route('auth.change-password') }}"><i class="fa fa-pencil-alt"></i> Change
                            Password</a></li>
                </ul>
            </li>
        </ul>
        <!-- end sidebar user -->
        <!-- begin sidebar nav -->
        <ul class="nav">
            <li class="nav-header">
                <a href="{{ route('dashboard') }}">
                    <span>Dashboard</span>
                </a>
            </li>
            @if(\App\Helpers\CommonHelper::hasPermission(['library-list', 'library-create', 'library-update', 'library-action']))
                <li class="has-sub @if(in_array( Request::segment(2), array('library')) ) active expand @endif">
                    <a href="javascript:;">
                        <b class="caret"></b>
                        <i class="fa fa-hdd"></i>
                        <span>Library</span>
                    </a>
                    <ul class="sub-menu"
                        style="@if(in_array( Request::segment(2), array('library')) ) display:block @endif">
                        <li><a href="{{ route('library.index', ['type' => 'book']) }}">Book</a></li>
                        <li><a href="{{ route('library.index', ['type' => 'journal']) }}">Journal</a></li>
                        <li><a href="{{ route('library.index', ['type' => 'magazine']) }}">Magazine</a></li>
                        <li><a href="{{ route('library.index', ['type' => 'document']) }}">Document</a></li>
                        <li><a href="{{ route('library.index', ['type' => 'seminar']) }}">Seminar Proceeding</a></li>
                    </ul>
                </li>
            @endif

            @if(\App\Helpers\CommonHelper::hasPermission(['category-list', 'category-create', 'category-update', 'category-action']))
                <li class="@if(in_array( Request::segment(2), array('category')) ) active  @endif"><a
                        href="{{ route('category.index') }}"><i class="fa fa-code-branch"></i> Category</a></li>
            @endif

            @if(\App\Helpers\CommonHelper::hasPermission(['season-list', 'season-create', 'season-update', 'season-action']))
                <li class="@if(in_array( Request::segment(2), array('season')) ) active  @endif"><a
                        href="{{ route('season.index') }}"><i class="fa fa-calendar"></i> Seasons</a></li>
            @endif


            @if(\App\Helpers\CommonHelper::hasPermission(['library-issue-list', 'library-issue-create', 'library-issue-update', 'library-issue-action']))
                <li class="has-sub @if(in_array( Request::segment(2), array('issue')) ) active expand @endif">
                    <a href="javascript:;">
                        <b class="caret"></b>
                        <i class="fa fa-gem"></i>
                        <span>Issues</span>
                    </a>

                    <ul class="sub-menu"
                        style="@if(in_array( Request::segment(2), array('issue')) ) display: block @endif">
                        <li>
                            <a href="{{ route('issue.create') }}">
                                <i class="fa fa-plus text-theme m-l-5"></i>
                                Create Issue
                            </a></li>
                        <li>
                            <a href="{{ route('issue.index') }}">
                                <i class="fa fa-paper-plane text-theme m-l-5"></i>
                                All Issue
                            </a></li>
                        <li>
                            <a href="{{ route('issue.index', ['type' => 'active']) }}">
                                <i class="fa fa-paper-plane text-theme m-l-5"></i>
                                Active Issues
                            </a></li>
                        <li>
                            <a href="{{ route('issue.index', ['type' => 'expire']) }}">
                                <i class="fa fa-paper-plane text-theme m-l-5"></i>
                                Expired Issues
                            </a></li>
                    </ul>
                </li>
            @endif
            @if(\App\Helpers\CommonHelper::hasPermission(['library-return-list', 'library-return-create', 'library-return-update', 'library-return-action']))
                <li class="@if(in_array( Request::segment(2), array('return')) ) active  @endif">
                    <a href="{{ route('return.index') }}">
                        <i class="fa fa-redo"></i>
                        <span>Returns</span>
                    </a>
                </li>
            @endif

            @if(\App\Helpers\CommonHelper::hasPermission(['member-list', 'member-create', 'member-update', 'member-action']))
                <li class="has-sub @if(in_array( Request::segment(2), array('member')) ) active expand @endif">
                    <a href="javascript:;">
                        <b class="caret"></b>
                        <i class="fa fa-users"></i>
                        <span>Members</span>
                    </a>
                    <ul class="sub-menu"
                        style="@if(in_array( Request::segment(2), array('member')) ) display: block @endif">

                        @if(\App\Helpers\CommonHelper::hasPermission(['member-create']))
                            <li>
                                <a href="{{ route('member.create') }}">
                                    <i class="fa fa-plus"></i>
                                    Create member
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="{{ route('member.index') }}">
                                <i class="fa fa-circle"></i>
                                All Members
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            @if(\App\Helpers\CommonHelper::hasPermission(['library-list', 'library-create', 'library-update', 'library-action']))
                <li class="has-sub @if(in_array( Request::segment(2), array('feature')) ) active expand @endif">
                    <a href="javascript:;">
                        <b class="caret"></b>
                        <i class="fa fa-list-alt"></i>
                        <span>Featured</span>
                    </a>
                    <ul class="sub-menu"
                        style="@if(in_array( Request::segment(2), array('feature')) ) display: block @endif">
                        <li>
                            <a href="{{ route('feature.index', ['type' => 'new_book']) }}">
                                <i class="fa fa-book"></i>
                                New Books
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('feature.index', ['type' => 'book']) }}">
                                <i class="fa fa-book"></i>
                                Top Books
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('feature.index', ['type' => 'journal']) }}">
                                <i class="fa fa-book"></i>
                                Top Journals
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('feature.index', ['type' => 'magazine']) }}">
                                <i class="fa fa-book"></i>
                                Top Magazines
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('feature.index', ['type' => 'document']) }}">
                                <i class="fa fa-book"></i>
                                Top Documents
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('feature.index', ['type' => 'seminar']) }}">
                                <i class="fa fa-book"></i>
                                Top Seminars
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            @if(\App\Helpers\CommonHelper::hasPermission(['role-list', 'role-create', 'role-update', 'role-action']))
                <li class="@if(in_array( Request::segment(2), array('role')) ) active  @endif">
                    <a href="{{ route('role.index') }}">
                        <i class="fa fa-user-secret"></i>
                        <span>Roles</span>
                    </a>
                </li>
            @endif
            <li>
                <form action="{{ route('auth.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-block">
                        <i class="fa fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </li>
            <!-- begin sidebar minify button -->
            <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i
                        class="fa fa-angle-double-left"></i></a></li>
            <!-- end sidebar minify button -->
        </ul>
        <!-- end sidebar nav -->
    </div>
    <!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>
<!-- end #sidebar -->
