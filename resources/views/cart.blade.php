@extends('frontend.app')

@section('owncss')
    <link rel="stylesheet" href="{{asset('/owlcarousel/assets/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('/owlcarousel/assets/owl.theme.default.min.css')}}">
    <style>
    #form1{
        display: block;
        float: right;
        padding-left: 10px;
    }
    #printablediv{

        margin-top: 50px;
    }

    @media print {
        a[href]:after {
        content: none !important;
        }
        .no_need_print{
            display: none;
        }
    }
        .cart_section{
            padding: 25px 0 50px 0;
        }
    </style>
@endsection

@section('content_search')
    <div class="search_replace_for_contact">

    </div>
@endsection


@section('content')

    <div class="container cart_section">
        <p><a href="{{ url('/') }}">Home</a> / Wishlist</p>
        <h3>Wishlist </h3>

        <hr>

        @if (session()->has('success_message'))
            <div class="alert alert-success">
                {{ session()->get('success_message') }}
            </div>
        @endif

        @if (session()->has('error_message'))
            <div class="alert alert-danger">
                {{ session()->get('error_message') }}
            </div>
        @endif

        @if (sizeof(Cart::content()) > 0)


            <a href="{{ url('/') }}" class="btn btn-success btn-sm"><i class="fa fa-undo" aria-hidden="true"></i> Continue for add item in your Wishlist </a> &nbsp;
            <form id="form1" runat="server">
            <button type="submit" onclick="javascript:printDiv('printablediv')" class="btn btn-success btn-sm" style="color:#fff"><i class="fa fa-print" aria-hidden="true"></i> Print Wishlist</button>
            </form>

            <div style="float:right">
                <form action="{{ url('/emptyPrint') }}" method="POST">
                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="DELETE">

                    <button type="submit" class="btn btn-danger btn-sm" style="background: #d9534f;border-color:#d9534f;color:#fff"><i class="fa fa-trash" aria-hidden="true"></i> Empty Wishlist</button>


                </form>
            </div>

                <div id="printablediv">
            <table class="table">
                <thead>
                    <tr>
                        <th class="table-image">Image</th>
                        <th>Details</th>
                        <!--<th>Quantity</th>-->
                        <th class="no_need_print">Action</th>


                    </tr>
                </thead>

                <tbody>
                    @foreach (Cart::content() as $item)

                        <?php
                       //echo "<pre>";
                      // print_r($item);
                        ?>
                    <tr>
                        <td class="table-image">

                            <a href="{{ route('single.show',$item->model->id) }}">
                                <?php
                                if( !empty($item->options->cover_photo)){
                                ?>
                                    <img src="{{Request::root()}}/uploads/books/{{ $item->options->cover_photo }}" class="img-responsive cart-image" alt="book"  width="50">
                                <?php
                                }else{
                                    ?>
                                    <img src="{{ asset('default/blank-cover.png') }}"  class="img-responsive cart-image" alt="book" width="50">

                                <?php
                                }
                                ?>
                            </a>
                        </td>
                        <td>


                            <?php echo ucfirst($item->options->type); ?> : {{ $item->model->title }}<br>

                             @if( $item->options->type == 'seminar' )
                                Organized By : {{ $item->options->author }}
                                @else
                                Author By : {{ $item->options->author }}
                            @endif;

                        </td>
                        <!--<td>
                            <select class="quantity" data-id="{{ $item->rowId }}">
                                <option {{ $item->qty == 1 ? 'selected' : '' }}>1</option>
                                <option {{ $item->qty == 2 ? 'selected' : '' }}>2</option>
                                <option {{ $item->qty == 3 ? 'selected' : '' }}>3</option>
                                <option {{ $item->qty == 4 ? 'selected' : '' }}>4</option>
                                <option {{ $item->qty == 5 ? 'selected' : '' }}>5</option>
                            </select>
                        </td>-->
                        <td class="no_need_print">
                            <form action="{{ url('print', [$item->rowId]) }}" method="POST" class="side-by-side">
                                {!! csrf_field() !!}
                                <input type="hidden" name="_method" value="DELETE">

                                <button type="submit" class="btn btn-danger btn-sm" style="background: #d9534f;border-color:#d9534f;color:#fff"><i class="fa fa-times" aria-hidden="true"></i></button>
                            </form>
                        </td>



                    </tr>

                    @endforeach


                    <!--<tr class="border-bottom">
                        <td class="table-image"></td>
                        <td  style="text-align: right">Total Number of Books</td>
                        <td class="small-caps table-bg">{{ Cart::instance('default')->count(false) }}</td>
                        <td class="table-bg"></td>
                        <td class="column-spacer"></td>
                        <td></td>
                    </tr>-->

                </tbody>
            </table>

                </div>




        @else

            <h4>You have no items in your Wishlist</h4>
            <a href="{{ url('/') }}" class="btn btn-primary btn-sm"><i class="fa fa-undo" aria-hidden="true"></i> Continue</a>

        @endif

        <div class="spacer"></div>










    </div> <!-- end container -->

@endsection

@section('ownjs')
    <script>
        (function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.quantity').on('change', function() {

                var id = $(this).attr('data-id')

                $.ajax({
                  type: "PATCH",
                  url: '{{ url("/print") }}' + '/' + id,
                  data: {
                    'quantity': this.value,
                  },
                  success: function(data) {

                    window.location.href = '{{ url('/print') }}';
                  }
                });

            });

        })();

    </script>


    <script language="javascript" type="text/javascript">
        function printDiv(divID) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
            document.body.innerHTML =
                "<html><head><title>Books Info For Print</title></head><body><div style='text-align:center;'><h2>Bangladesh Institute of International and Strategic Studies (BIISS)</h2><h4>Books Info For Print</h4></div>" +
                divElements + "</body>";

            //Print Page
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = oldPage;


        }
    </script>


@endsection
