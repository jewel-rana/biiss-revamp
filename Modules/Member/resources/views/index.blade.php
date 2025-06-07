@extends("{$theme['default']}::layouts.master")
@section('content')

    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('member.create') }}">Create new member</a>
            </div>
        </div>
    </div>

    <!----------------------search start-------------------------->
    <div class="row mb-3">
        <div class="col-lg-4">
            <form action="{{ route('member.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search for..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-secondary">Go!</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!----------------------search end-------------------------->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            {{ $message }}
                        </div>
                    @endif
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                            <tr>
                                <th width="5%">Member ID</th>
                                <th width="15%">Name</th>
                                <th width="25%">Email</th>
                                <th width="10%">Contact Number</th>
                                <th width="10%">Book Issues</th>
                                <th width="10%">Address</th>
                                <th width="5%">Avatar</th>
                                <th width="10%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($members as $member)
                                <tr>
                                    <td>{{ $member->account_id }}</td>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->email }}</td>
                                    <td>{{ $member->contact_number }}</td>
                                    <td>
                                        @if(!empty($member->roles))
                                            @foreach($member->roles as $v)
                                                <span class="badge badge-success d-inline-block mb-1">{{ $v->display_name }}</span>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('user.show',$member->id) }}?tab=history">
                                            {{ $member->issued_books_count }} Books
                                        </a>
                                    </td>
                                    <td>
                                        @if ($member->avatar)
                                            <img src="{{ $member->avatar }}" width="60" height="45" alt="Avatar">
                                        @else
                                            <img src="{{ asset('default/avatar.png') }}" width="60" height="45" alt="Default Avatar">
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Action Buttons">
                                            <a class="btn btn-sm btn-info" href="{{ route('member.show', $member->id) }}">Show</a>
                                            <a class="btn btn-sm btn-warning" href="{{ route('member.edit', $member->id) }}">Edit</a>
                                            <form action="{{ route('member.destroy', $member->id) }}" method="POST" class="delete d-inline-block" onsubmit="return confirm('Do you want to delete this?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                        {!! $members->appends(Request::except('page'))->links('pagination::bootstrap-4') !!}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('ownjs')
    <!-- Optional: if you prefer confirmation with JS, but inline confirm in form is also fine -->
@endsection
