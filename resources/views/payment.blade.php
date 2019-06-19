@extends('layouts/main')
@section('content')

    <!-- Checkout Content -->
    <div class="container-fluid no-padding checkout-content" style="margin-top: 40px">
        <!-- Container -->
        <div class="container">
            @if(!Auth::user()->detail->address)
                <div class="alert alert-danger">
                    Please <strong>Complete</strong> Your Profile!
                    <br><a href="/profile/{{auth()->user()->id}}/edit">Edit Profile</a>
                </div>
            @else
                <div class="row">
                    <form action="{{ route('dopay') }}" method="POST" id="subscribe-form" class="col-md-12" onsubmit="return submitpayment()">
                        {{-- {{csrf_field()}} --}}
                        @csrf
                        <div class="section-padding"></div>

                        <!-- Order Summary -->
                        <!-- Payment Mode -->
                        <div class="col-md-12 payment-mode">
                            <div class="section-title">
                                <h3>CONTACT AND INVOICE INFORMATION...</h3>
                            </div>

                            <div class="section-padding"></div>
                            <div class="container">


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                   value="{{Auth::user()->name}}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="surname">Surname</label>
                                            <input type="text" class="form-control" name="surname" id="surname"
                                                   value="{{Auth::user()->surname}}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Phone</label>
                                            <input type="text" class="form-control phone" name="phone" id="phone"
                                                   value="{{$user_detail->phone}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="m_phone">Mobile Phone</label>
                                            <input type="text" class="form-control m_phone" name="m_phone" id="m_phone"
                                                   value="{{$user_detail->m_phone}}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="city">City</label>
                                            <input type="text" class="form-control city" name="city" id="city"
                                                   placeholder="{{$user_detail->city}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="country">Country</label>
                                            <input type="text" class="form-control country" name="country" id="country"
                                                   placeholder="{{$user_detail->country}}" required disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="zipcode">Zip Code</label>
                                            <input type="text" class="form-control zipcode" name="zipcode" id="zipcode"
                                                   placeholder="{{$user_detail->zipcode}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <input type="text" class="form-control" name="address" id="address"
                                                   value="{{ $user_detail->address }}" required>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <br><br>
                            <div class="text-center alert alert-info">
                                <h4>TOTAL PRICE</h4>
                                <span class="price">
                                    @foreach($chartHistory as $productCartItem)
                                        Rp. {{number_format($productCartItem->total)}}
                                    @endforeach
                                    {{-- {{ Cart::total() }} --}}
                                    {{-- <small> ₺</small> --}}
                                </span>
                            </div>


                            <div class="section-padding"></div>
                        </div>
                        <!-- Order Summary /- -->

                        <div style="text-align: center; margin-bottom: 20px">
                            <span id="alert-danger" class="alert alert-danger d-none"></span>
                            <span id="alert-success" class="alert alert-success d-none"></span>
                        </div>

                        <!-- Payment Mode -->
                        <div class="container-">
                            <div class="row">
                                <div class="col-md-12">
                                    {!! $getFormContent !!}
                                    <div class="wc-proceed-to-checkout">
                                        <input type="submit" class="btn text-white pull-left red_button" value="ORDER">
                                        {{-- <a href="{{route('payment')}}" class="red_button" title="CHECKOUT">ORDER</a> --}}
                                    </div>

                                    <div id="iyzipay-checkout-form" class="responsive"></div>
                                </div>

                                <br><br>

                                <div class="section-padding"></div>
                            </div>
                        </div>

                        <input type="hidden" name="stripeToken" id="stripeToken" value="" /> 
                    </form>
                </div>
            @endif
        </div><!-- Container /- -->
    </div><!-- Checkout Content /- -->


    
@endsection

@section('js')
<script src="https://checkout.stripe.com/checkout.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script> 


<script type="text/javascript">
    function showProcessing() {
        $('.subscribe-process').show();
    }
    function hideProcessing() {
        $('.subscribe-process').hide();
    }

    // Handling and displaying error during form submit.
    function subscribeErrorHandler(jqXHR, textStatus, errorThrown) {
        try {
            var resp = JSON.parse(jqXHR.responseText);
            if ('error_param' in resp) {
                var errorMap = {};
                var errParam = resp.error_param;
                var errMsg = resp.error_msg;
                errorMap[errParam] = errMsg;
            } else {
                var errMsg = resp.error_msg;
                $("#alert-danger").addClass('alert alert-danger').removeClass('d-none').text(errMsg);
            }
        } catch (err) {
            $("#alert-danger").show().text("Error while processing your request");
        }
    }

    // Forward to thank you page after receiving success response.
    function subscribeResponseHandler(responseJSON) {
    //window.location.replace(responseJSON.successMsg);
        if (responseJSON.state == 'success') {
            $("#alert-success").addClass('alert alert-success').removeClass('d-none').text(responseJSON.message);
            $("#alert-danger").addClass('d-none');
        }
        if (responseJSON.state == 'error') {
            $("#alert-danger").addClass('alert alert-danger').removeClass('d-none').text(responseJSON.message);
            $("#alert-success").addClass('d-none');
        }

    }
    var handler = StripeCheckout.configure({
    //Replace it with your stripe publishable key
        key: "{{ env('STRIPE_KEY') }}",
        image: 'https://networkprogramming.files.wordpress.com/2018/10/twitter.png', // add your company logo here
        allowRememberMe: false,
        token: handleStripeToken
    });

    function submitpayment() {
        // var form = $("#subscribe-form");
        // if (parseInt($("#amount").val()) <= 0) {
        //     return false;
        // }
        handler.open({
            name: 'Laravel Stripe Payment'
            // description: $("#plan").val()+' Plan',
            // amount: ($("#amount").val() * 100)
        });
        return false;
    }

    function handleStripeToken(token, args) {
        form = $("#subscribe-form");
        $("input[name='stripeToken']").val(token.id);
        var options = {
            beforeSend: showProcessing,
            // post-submit callback when error returns
            error: subscribeErrorHandler,
            // post-submit callback when success returns
            success: subscribeResponseHandler,
            complete: hideProcessing,
            contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            dataType: 'json'
        };

        form.ajaxSubmit(options);
        return false;
    }

    $("#submit-btn-1").click(function(){
        $("#amount").val('9');
        $("#plan").val('Basic');
    });
    $("#submit-btn-2").click(function(){
        $("#amount").val('19');
        $("#plan").val('Premium');
    });
</script>
@endsection
