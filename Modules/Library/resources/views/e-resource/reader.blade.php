@extends("{$theme['frontend']}::layouts.master")

@section('header')
    <style>
        .toolbar {
            flex: 0 0 auto; /* fixed height */
            background: #eee;
            padding: 5px;
            border-bottom: 1px solid #ccc;
            z-index: 9999;
        }

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
                        <h2 class="fw-bold text-primary">
                            {{ $library->title }}
                            @if( $library->volume_number != null )
                                [{{ $library->volume_number }}]
                            @endif
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="toolbar">
                    <button onclick="zoomIn()">Zoom In</button>
                    <button onclick="zoomOut()">Zoom Out</button>
                    <!-- more buttons -->
                </div>

                <div class="pdf-container">
                    <iframe
                        src="{{ route('library.pdf', $library->id) }}"
                        width="100%"
                        style="overflow: auto;">
                    </iframe>
                </div>
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
