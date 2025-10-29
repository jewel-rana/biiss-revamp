@extends("{$theme['frontend']}::layouts.master")

@section('header')
    <style>

        .pdf-container {
            flex: 1 1 auto; /* take remaining space */
            overflow: auto; /* enable scrolling only here */
        }

        iframe {
            position: fixed;
            left: 0;
            top: 270px;
            bottom: 0;
            height: 70vh;
            right: 0;
            border: none;
            z-index: 999999;
        }
    </style>
@endsection

@section('content')
    <!-- Book Details Section -->
    <div class="container py-5">
        <div class="row g-4">
            <!-- Book Properties -->
            <div class="col-md-12">
                <div class="justify-content-between">
                    <div class="">
                        <h6 class="fw-bold  text-center">
                            {{ $library->title }}
                            @if( $library->volume_number)
                                [{{ $library->volume_number }}]
                            @endif
                            @if( $library->call_number)
                                [{{ $library->call_number }}]
                            @endif

                            @if(auth()->check())
                                <span>
                                    @if(auth()->user()->type == 'admin')
                                        <a href="{{ route('library.edit', $library->id) }}" target="_blank"
                                           class="btn btn-sm btn-outline-secondary"><i class="fa fa-edit"></i> Edit</a>
                                    @endif
                                <a href="{{ route('library.download', [$library->type, $library->id]) }}"
                                   class="btn btn-sm btn-outline-secondary"><i class="fa fa-download"></i> Download</a>
                            </span>
                            @endif
                        </h6>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                @if(auth()->check())
                    <div class="pdf-container">
                        <iframe
                            src="{{ asset('storage/' . $library->file) }}"
                            width="100%"
                            style="overflow: auto;">
                        </iframe>
{{--                        <iframe--}}
{{--                            src="{{ route('library.pdf', $library->id) }}"--}}
{{--                            width="100%"--}}
{{--                            style="overflow: auto;">--}}
{{--                        </iframe>--}}
                    </div>
                @endif
            </div>
        </div>

    </div>

@endsection

@section('footer')
    <script>
        let scale = 1.5;

        function zoomIn() {
            scale += 0.2;
            renderPage(pageNum);
        }

        function zoomOut() {
            if (scale > 0.4) {
                scale -= 0.2;
                renderPage(pageNum);
            }
        }
    </script>
@endsection
