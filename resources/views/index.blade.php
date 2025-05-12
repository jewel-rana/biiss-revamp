@extends("{$theme['frontend']}::layouts.master")

@section('content')
    <x-frontend::popular-books :books="$featuredBooks"></x-frontend::popular-books>

    <x-frontend::new-books :books="$newBooks"></x-frontend::new-books>

    <x-frontend::top-books :books="$featuredBooks"></x-frontend::top-books>

    <x-frontend::top-journal :books="$featuredJournals"></x-frontend::top-journal>

    <x-frontend::seminar-proceding :books="$featuredSeminars"></x-frontend::seminar-proceding>
@endsection
