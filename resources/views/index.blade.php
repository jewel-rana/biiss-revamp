@extends("{$theme['frontend']}::layouts.master")

@section('header')
    <style>
        /* Apply Bootstrap's form-control behavior to Awesomplete input */
        .awesomplete input.form-control {
            width: 100%;
            box-sizing: border-box;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }

        /* Suggestion dropdown positioning */
        .awesomplete ul {
            position: absolute;
            top: 100%; /* place directly below input */
            left: 0;
            right: 0; /* match container width */
            z-index: 1000;
            margin: 0;
            padding: 0;
            list-style: none;
            background-color: #fff;
            border: 1px solid #ced4da;
            border-top: none;
            max-height: 250px;
            overflow-y: auto;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
        }

        /* Suggestion list items */
        .awesomplete li {
            padding: 0.5rem 1rem;
            cursor: pointer;
            border-bottom: 1px solid #f1f1f1;
            font-size: 14px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Active/hover styling */
        .awesomplete li:hover,
        .awesomplete li[aria-selected="true"] {
            background-color: #e9ecef;
            color: #212529;
        }
        .search-input {
            width: 100% !important;
            min-width: 220px !important;
            max-width: 100% !important;
        }
    </style>
@endsection
@section('content')
    {{--    <x-frontend::popular-books :books="$featuredBooks"></x-frontend::popular-books>--}}

    <x-frontend::new-books :books="$newBooks"></x-frontend::new-books>

    <x-frontend::top-books :books="$featuredBooks"></x-frontend::top-books>

    <x-frontend::top-journal :books="$featuredJournals"></x-frontend::top-journal>

    <x-frontend::top-papers :books="$featuredDocuments"></x-frontend::top-papers>

    <x-frontend::seminar-proceding :books="$featuredSeminars"></x-frontend::seminar-proceding>
@endsection

@section('footer')
    <script type="text/javascript" src="{{ asset('plugins/awesomplete/awesomplete.min.js') }}"></script>
    <script>
        function getXHR() {
            if (window.XMLHttpRequest) return new XMLHttpRequest();
            return new ActiveXObject("Microsoft.XMLHTTP");
        }

        function initAwesomplete() {
            const input = document.getElementById("keywordSearch");

            const awesomplete = new Awesomplete(input);

            input.onkeyup = function (e) {
                const code = (e.keyCode || e.which);

                if ([37, 38, 39, 40, 27, 13].includes(code)) return;

                const value = this.value;

                const xhr = getXHR();
                const requestUrl = `/ajax/library/front/suggestions/${encodeURIComponent(value)}`;

                xhr.open("GET", requestUrl, true);

                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 304)) {
                        try {
                            const list = JSON.parse(xhr.responseText);
                            awesomplete.list = list;
                            awesomplete.data = function (i, input) {
                                return { label: i.level, value: i.value };
                            }
                        } catch (e) {
                            console.error("Invalid JSON returned:", xhr.responseText);
                        }
                    }
                };
                xhr.send();
            };
        }



        function initAuthorAwesomplete() {
            const input = document.getElementById("authorSearch");

            const awesomplete = new Awesomplete(input);

            input.onkeyup = function (e) {
                const code = (e.keyCode || e.which);

                if ([37, 38, 39, 40, 27, 13].includes(code)) return;

                const value = this.value;

                const xhr = getXHR();
                const requestUrl = `/ajax/library/front/author-suggestions/${encodeURIComponent(value)}`;

                xhr.open("GET", requestUrl, true);

                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 304)) {
                        try {
                            const list = JSON.parse(xhr.responseText);
                            awesomplete.list = list;
                            awesomplete.data = function (i, input) {
                                return { label: i.level, value: i.value };
                            }
                        } catch (e) {
                            console.error("Invalid JSON returned:", xhr.responseText);
                        }
                    }
                };
                xhr.send();
            };
        }

        // Run when page loads
        window.addEventListener('load', initAwesomplete);
        window.addEventListener('load', initAuthorAwesomplete);
    </script>
@endsection
