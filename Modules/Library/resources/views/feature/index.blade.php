@extends("{$theme['default']}::layouts.master")

@section('content')
    <!-- begin panel -->


    <!-- begin dropdown -->
    <div class="dropdown mb-3">
        <a href="javascript:;" class="btn btn-white btn-white-without-border dropdown-toggle" data-toggle="dropdown">
            {{ ucfirst( str_replace( '_', ' ', $type ) ) }}
        </a>
        <ul class="dropdown-menu" role="menu">
            <li><a href="{{ route('feature.index', ['type' => 'book']) }}">Book</a></li>
            <li><a href="{{ route('feature.index', ['type' => 'journal']) }}">Journal</a></li>
            <li><a href="{{ route('feature.index', ['type' => 'seminar']) }}">Seminar</a></li>
        </ul>
    </div>
    <!-- end dropdown -->
    <div class="clearfix"></div>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="{{ route('feature.create', ['type' => $type] ) }}" class="btn btn-xs btn-success"><i
                        class="fa fa-plus"></i> Add new</a>
            </div>
            <h4 class="panel-title">{{ $pageTitle }}</h4>
        </div>
        <div class="panel-body">
            <table class="table table-bordered">
                <tr>
                    <th><i class="fa fa-image"></i></th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
                @if( !empty( $items ) && is_object( $items ) )
                    @foreach ($items as $key => $item)
                        <tr id="parent">
                            <td>
                                    <?php
                                if ($item->item['cover_photo'] == !null){ ?>
                                <img src="{{ asset( $item->item['cover_photo'] ) }}" width="50" height="50">
                                <?php } else { ?>
                                <img src="{{ asset('default/cover/' . strtolower( $item->item['type'] ) . '.jpg') }}"
                                     width="50" height="50">
                                <?php } ?>
                            </td>
                            <td>
                                <a href="{{ route('library.show', $item->item['id'] ) }}" target="_blank"
                                   title="{{ $item->item['title'] }}">
                                        <?php
                                        $title = substr($item->item['title'], 0, 50);
                                        echo $title . '...';
                                        ?>
                                </a>
                            </td>
                            <td>
                                @if( $item->item['authors'] )
                                    @foreach( $item->item['authors'] as $author )
                                        <span class="badge badge-info">{{ $author['author_name'] }}</span>
                                    @endforeach
                                @endif
                            </td>
                            <td>{{ ucwords($item->type) }}</td>
                            <td>
                                <div class="btn-group w-100 d-flex" role="group" aria-label="Basic example"
                                     style="width:100%;">
                                    <form action="{{ route('feature.destroy', [$item->id, 'type' => $item->type]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button id="{{ $item->id }}"
                                                data-url="{{ route('feature.destroy', $item->id) }}"
                                                onclick="return confirm('Are you sure to remove items from featured list?')"
                                                class="btn btn-xs btn-danger deleteItem">
                                            <i class="fa fa-times"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">
                            <div class="alert alert-warning">
                                <h4>!Empty List</h4>
                                <p>Sorry! no items found.</p>
                            </div>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>

@endsection

@section('ownjs')

    <script type="text/javascript">
        jQuery(function () {
            $('.deleteItem').on("click", function () {
                var item = $(this);
                var parent = $(this).parents('#parent');
                let url = $(this).data('url');
                var data = null;

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "DELETE",
                    url: url,
                    data: data,
                    success: function (data, textStatus, xhr) {
                        if (xhr.status == 200) {
                            $(parent).remove();
                        }
                    }
                });

                return false;
            });
        });
    </script>

@endsection
