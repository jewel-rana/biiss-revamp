@extends("{$theme['default']}::layouts.master")

@section('header')
@endsection

@section('content')
    <div id="content">
        <div class="outer">
            <div class="inner bg-light p-3"> <!-- 'no-padding' isn't a Bootstrap 4 class -->

                <h3>{{ $title ?? "User: {$user->name}" }}</h3>

                <!-- Nav tabs -->
                <ul class="nav nav-tabs menuTab" id="userTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active show" id="info-tab" data-toggle="tab" href="#home" role="tab"
                           aria-controls="home" aria-selected="true">Info</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content mt-3">
                    <div class="tab-pane fade show active"
                         id="home"
                         role="tabpanel"
                         aria-labelledby="info-tab">
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <th style="width: 30%">ID</th>
                                <td>{{ $user->id }}</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>Role</th>
                                <td>{{ $user->roles->first()->name ?? '---' }}</td>
                            </tr>
                            <tr>
                                <th>Created at</th>
                                <td>{{ $user->created_at }}</td>
                            </tr>
                            <tr>
                                <th>Last updated at</th>
                                <td>{{ $user->updated_at }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection



