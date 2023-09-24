@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://js.stripe.com/v3/"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .payment-form-icon {
            line-height: 46px;
            margin-right: 10px;
            color: #dddddd !important;
        }

        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 80%;
            color: #f46a6a;
        }
    </style>
@endsection
@section('content')

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0 font-size-18">Lists</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">

                                        </ol>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header bg-soft-dark ">
                                       payment


                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title text-center">
                                            Payment
                                        </h3>
                                        @if (Session::has('success'))
                                        <div class="alert alert-success text-center">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                            <p>{{ Session::get('success') }}</p><br>
                                        </div>
                                        @endif


                                        @if (Session::has('error'))
                                        <div class="alert alert-success text-center">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                            <p>{{ Session::get('error') }}</p><br>
                                        </div>
                                        @endif

                                        <form id="payment-form" action="{{ route('payment.process') }}" method="post">
                                            @csrf
                                            <!-- Credit Card Number -->
                                            <div class="form-group required">
                                                <label for="cc-number"><i class="fas fa-credit-card"></i> Credit Card Number <small class="text-muted">[<span data-payment="cc-brand"></span>]</small></label>
                                                <div class="input-group">
                                                    <span class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                                                    </span>
                                                    <div id="cc-number" class="input-lg form-control"></div> <!-- Use a div here instead of an input -->
                                                </div>
                                            </div>
                                            <div id="card-errors" role="alert" class="invalid-feedback"></div>

                                            <button type="button" class="btn btn-primary btn-block" id="submit-button">Pay Now ${{  @$price }}</button>
                                        </form>



                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->


@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>

    $(document).ready(function() {
        const stripe = Stripe('pk_test_51MtZDzApRCJCEL2v4N99StaGAL6Z3fTpGsbRdHiIlSiF4BlNvkheZhl2PrDVB0xZ2FH7GNtP8E66wWKTtQNk5uIj00jqUIwU2M'); // Replace with your actual Stripe publishable key
        const elements = stripe.elements();

        const card = elements.create('card', {
            style: {
                base: {
                    fontSize: '16px',
                    color: '#32325d',
                },
            },
        });

        // Add the card element to your form
        card.mount('#cc-number');

        // Handle real-time validation errors on the card element
        card.addEventListener('change', function(event) {
            const displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        $("#submit-button").click(function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to proceed with the payment?')) {
                // Disable the button and change its text
                $(this).prop('disabled', true).text('Processing...');

                // Create a PaymentIntent on your server
                $.ajax({
                    type: 'POST',
                    url: '{{ route('payment.create_intent') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        amount: {{ $price * 100 }}, // Convert to cents
                    },
                    success: function(data) {
                        // Handle the response from your server
                        if (data.client_secret) {
                            stripe.confirmCardPayment(data.client_secret, {
                                payment_method: {
                                    card: card,
                                },
                            }).then(function(result) {
                                if (result.error) {
                                    // Show error message to the user
                                    const errorElement = document.getElementById('card-errors');
                                    errorElement.textContent = result.error.message;

                                    // Re-enable the button and restore its text
                                    $("#submit-button").prop('disabled', false).text('Pay Now ${{ @$price }}');
                                } else {
                                    // Payment succeeded, proceed with form submission
                                    const form = document.getElementById('payment-form');
                                    const paymentMethodInput = document.createElement('input');
                                    paymentMethodInput.setAttribute('type', 'hidden');
                                    paymentMethodInput.setAttribute('name', 'payment_intent_id');
                                    paymentMethodInput.setAttribute('value', result.paymentIntent.id);
                                    form.appendChild(paymentMethodInput);
                                    form.submit();
                                }
                            });
                        }
                    },
                    error: function(error) {
                        console.error(error);

                        // Re-enable the button and restore its text
                        $("#submit-button").prop('disabled', false).text('Pay Now ${{ @$price }}');
                    }
                });
            } else {
                toastr.info('Payment Cancel: ', {
                    timeOut: 9000, // Set the duration (5 seconds in this example)
                });
            }
        });

    });
</script>

@endsection
