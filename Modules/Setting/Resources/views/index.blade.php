@extends("{$theme['default']}::layouts.master")

@section('header')
    <style>
        .form-horizontal .form-group {
            margin-right: 0 !important;
            margin-left: 0 !important;
        }
    </style>
@endsection

@section('content')
    <div id="content">
        <div class="outer">
            <div class="inner bg-light p-3"> {{-- added p-3 for padding --}}
                <h3>{{ $title ?? 'Settings' }}</h3>
                <div>
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link @if($tab === 'general') active @endif"
                               id="general-tab" data-toggle="tab" href="#general"
                               role="tab" aria-controls="general"
                               aria-selected="@if($tab === 'general') true @else false @endif">
                                General
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if($tab === 'footer') active @endif"
                               id="footer-tab" data-toggle="tab" href="#footer"
                               role="tab" aria-controls="footer"
                               aria-selected="@if($tab === 'footer') true @else false @endif">
                                Footer
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if($tab === 'seo') active @endif"
                               id="seo-tab" data-toggle="tab" href="#seo"
                               role="tab" aria-controls="seo"
                               aria-selected="@if($tab === 'seo') true @else false @endif">
                                SEO
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content p-3 border border-top-0"> {{-- p-3 and border for better styling --}}
                        <div class="tab-pane fade @if($tab === 'general') show active @endif"
                             id="general" role="tabpanel" aria-labelledby="general-tab">
                            @include('setting::general')
                        </div>
                        <div class="tab-pane fade @if($tab === 'footer') show active @endif"
                             id="footer" role="tabpanel" aria-labelledby="footer-tab">
                            @include('setting::footer')
                        </div>
                        <div class="tab-pane fade @if($tab === 'seo') show active @endif"
                             id="seo" role="tabpanel" aria-labelledby="seo-tab">
                            @include('setting::seo')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            let table = $('#attributeTables').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: '{{ route('setting.attribute.index') }}',
                    data: function (data) {}
                },
                bAutoWidth: false,
                sPageButtonActive: "active",
                dom: 'lr<"toolbar">tip',
                lengthChange: true,
                lengthMenu: [[25, 50, 100, 500, -1], [25, 50, 100, 500, "All"]],
                pageLength: 25,
                bFilter: true,
                bInfo: true,
                searching: true,
                order: [[0, "desc"]],
                columns: [
                    {"data": 'key'},
                    {"data": 'lang'},
                    {"data": 'value'},
                    {"data": 'actions'}
                ]
            });

            $('#settingAttributeForm').submit(function (e) {
                e.preventDefault();
                let url = $(this).attr('action');
                let data = $(this).serialize();
                let form = $(this);
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    success: function (response) {
                        table.draw();
                        form.trigger("reset");
                        Toast.fire({
                            icon: response.status ? 'success' : 'error',
                            title: response.message
                        });
                    }
                });
            });

            $('#attributeKey').select2({
                width: "100%",
                allowClear: true,
                placeholder: "Select key",
                delay: 250,
                ajax: {
                    url: '{{ route('setting.suggestion') }}',
                    dataType: 'json',
                    data: function (params) {
                        return {
                            term: params.term,
                            lang: $('#attributeLang').val()
                        };
                    },
                    processResults: function (data) {
                        return {results: data.data};
                    }
                }
            });

            $('table').on('click', '.deleteAttribute', function () {
                let action = $(this).data('action');
                $.ajax({
                    type: "DELETE",
                    url: action,
                    success: function (response) {
                        table.draw();
                        Toast.fire({
                            icon: response.status ? 'success' : 'error',
                            title: response.message
                        });
                    }
                });
            });
        });
    </script>
@endsection
