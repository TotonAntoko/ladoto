@extends('layouts/main')

@section('content')

    <!-- Checkout Content -->
    <div class="container-fluid no-padding checkout-content" style="margin-top: 40px;">
        <!-- Container -->
        <div class="container">
            <div class="row">
                <!-- Order Summary -->
                <div class="col-md-12 order-summary">
                    <div class="section-padding"></div>
                    <!-- Section Header -->
                    <div class="section-header">
                        <h3>WISHLIST</h3>
                    </div><!-- Section Header /- -->
                    <div class="order-summary-content">
                        @if(count(Cart::content())>0)
                            <table class="shop_cart">
                                <thead>
                                <tr>
                                    <th class="product-name">PRODUCT NAME</th>
                                    <th class="product-price">UNIT PRICE</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach(Cart::content() as $productCartItem)
                                    <tr class="cart_item">


                                        <td data-title="{{$productCartItem->name}}" class="product-name">
                                            <a title="{{$productCartItem->name}}" href="{{ route('product', $productCartItem->options->slug) }}">
                                                {{$productCartItem->name}}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="6">
                                        <form action="{{route('wishlist.destroy')}}" method="POST">
                                            {{csrf_field()}}
                                            {{method_field('DELETE')}}
                                            <input type="submit" class="btn pull-left" value="CLEAR ALL">
                                        </form>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                            
                        @else
                            <div class="container-fluid no-padding checkout-content">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12 order-summary">
                                            <div class="alert alert-danger text-center">
                                                <h2>No items in your wishlist !</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </div><!-- Order Summary /- -->



            </div>

        </div><!-- Container /- -->
        <div class="section-padding"></div>
    </div><!-- Checkout Content /- -->
@endsection


@section('js')
    <script>
        $(function(){
            $('.quantityf').on('change', function() {
                var id = $(this).attr('data-id');
                toastr.options.timeOut = 4500;
                $.ajax({
                    type: "PATCH",
                    url: '{{ url('wishlist/update') }}' + '/' + id,
                    data: {
                        'quantity': this.value,
                    },
                    success: function(data) {
                        console.log(data);

                        toastr.success('Updated successfully!');
                        window.location.href = '{{ route('wishlist') }}';
                    }
                });
            });
        });
    </script>
@endsection

