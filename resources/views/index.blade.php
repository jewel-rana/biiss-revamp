@extends("{$theme['frontend']}::layouts.master")

@section('content')
    <x-frontend::popular-books></x-frontend::popular-books>

    <x-frontend::new-books></x-frontend::new-books>

    <x-frontend::top-books></x-frontend::top-books>

    <x-frontend::top-journal></x-frontend::top-journal>

    <x-frontend::seminar-proceding></x-frontend::seminar-proceding>
@endsection
