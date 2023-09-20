@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    <style>
        .custom-table {
            border-collapse: collapse;
            width: 100%;
        }

        .custom-table th,
        .custom-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        .custom-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .highlight-column {
            background-color: #f0f1f5;
        }

        #stripeModal {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .modal-dialog {
            max-width: 400px; /* Adjust the modal width as needed */
        }

        /* Adjust input field width */
        #card-element {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        /* Style the submit button */
        #stripe-payment-form button[type="submit"] {
            width: 100%;
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        /* Style the cancel button */
        #stripe-payment-form button[type="button"] {
            width: 100%;
            background-color: #ccc;
            color: #333;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        /* Add spacing between elements */
        #stripe-payment-form .form-group {
            margin-bottom: 10px;
        }

        /* Center the modal header */
        #stripeModal .modal-header {
            text-align: center;
        }

        /* Center the modal footer buttons */
        #stripeModal .modal-footer {
            justify-content: center;
        }

        .custom-table {
                border-collapse: collapse;
                width: 100%;
            }

            .custom-table th,
            .custom-table td {
                padding: 12px 15px;
                text-align: left;
                border-bottom: 1px solid #dee2e6;
            }

            .custom-table th {
                background-color: #f8f9fa;
                font-weight: bold;
            }

            .highlight-column {
                background-color: #f0f1f5;
            }

            .amount {
                font-weight: bold;
                font-family: Arial, sans-serif;
            }

            .status {
                display: inline-block;
                border-radius: 5px;
                padding: 5px 10px;
                font-family: 'Arial', sans-serif;
                font-weight: bold;
            }

            .succeeded {
                background-color: #66BB6A;
                color: white;
                padding: 5px;
                border-radius: 5px;
                box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            }

            .pending {
                background-color: #FFCA28;
                color: white;
                padding: 5px;
                border-radius: 5px;
                box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            }

            .failed {
                background-color: #EF5350;
                color: white;
                padding: 5px;
                border-radius: 5px;
                box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            }
    </style>
@endsection
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Settings</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item">Settings</li>
                        </ol>
                    </div>
                </div>
                <div class="card shadow-lg  ">
                    <div class="card-header bg-soft-dark ">
                        <i class="fas fa-cog"></i> Admin Settings
                    </div>
                    <div class="card-body">
                        <div class="col-12">
                            <div class="text-right mb-3">
                                <h4 class="font-size-18">Total Deposited Amount: $</h4>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <a href="#" class="text-decoration-none" id="stripe-option">
                                        <div class="card shadow text-white" style="background: #2a3042;">
                                            <div class="card-body">
                                                <h5 class="card-title"><i class="fas fa-stripe text-success"></i class="text-white"> Stripe</h5>
                                                <p class="card-text">Make a deposit with Stripe.</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <a href="#" class="text-decoration-none">
                                        <div class="card shadow text-white" style="background: #2a3042;">
                                            <div class="card-body">
                                                <h5 class="card-title"><i class="fab fa-paypal text-primary"></i> PayPal</h5>
                                                <p class="card-text">Make a deposit with PayPal.</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="card shadow-lg">

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered custom-table">
                                            <thead>
                                                <tr>
                                                    <th>Transaction Id</th>
                                                    <th>Payment Method</th>
                                                    <th class="highlight-column">Amount</th>
                                                    <th>Currency</th>
                                                    <th>Transaction Date</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody id="transaction-table-body" data-payment-table>
                                                @foreach($transactions as $transaction)
                                                <tr>
                                                    <td>{{ $transaction->transaction_id }}</td>
                                                    <td>{{ $transaction->payment_method }}</td>
                                                    <td class="amount">{{ $transaction->amount }}</td>
                                                    <td>{{ $transaction->currency }}</td>
                                                    <td>{{ date('d M Y h:i A', strtotime($transaction->transaction_date)) }}</td>
                                                    <td class="status">
                                                        <span class="
                                                        @if ($transaction->status === 'succeeded')
                                                            succeeded
                                                        @elseif ($transaction->status === 'pending')
                                                            pending
                                                        @else
                                                            failed
                                                        @endif
                                                    " > {{ $transaction->status }}</span>

                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{ $transactions->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Stripe Payment Modal -->
        <div class="modal fade" id="stripeModal" tabindex="-1" role="dialog" aria-labelledby="stripeModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="stripeModalLabel">Stripe Payment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="stripe-payment-form">
                            <div class="form-group">
                                <label for="amount">Amount ($)</label>
                                <input type="number" class="form-control" id="amount" name="amount" required>
                            </div>
                            <div id="card-element">

                                <!-- A Stripe Element will be inserted here. -->
                            </div>
                            <input type="hidden" id="payment_method" name="payment_method" value="">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="pay-with-stripe-button">Pay with Stripe</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- container-fluid -->
</div>



@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        $(document).ready(function () {
            $('#datatable').DataTable();

        });
    </script>

<script>
   $(document).ready(function () {
        // Initialize Stripe outside of the event handler
        var stripe = Stripe('pk_test_51MtZDzApRCJCEL2v4N99StaGAL6Z3fTpGsbRdHiIlSiF4BlNvkheZhl2PrDVB0xZ2FH7GNtP8E66wWKTtQNk5uIj00jqUIwU2M'); // Replace with your actual Stripe public key
        var elements = stripe.elements();
        var cardElement = elements.create('card');

        // Mount the card element to the DOM
        cardElement.mount('#card-element');

        // Flag to track whether the payment button is disabled
        var isPaymentButtonDisabled = false;

        // Get a reference to the payment button
        var paymentButton = $('#pay-with-stripe-button');

        // Handle Stripe payment form submission
        $('#stripe-payment-form').submit(function (e) {
            e.preventDefault();

            if (isPaymentButtonDisabled) {
                return; // Don't allow multiple submissions
            }

            // Disable the payment button and change text to "Processing..."
            paymentButton.prop('disabled', true).text('Processing...');
            isPaymentButtonDisabled = true;

            // Create a Payment Method using the card element
            stripe.createPaymentMethod({
                type: 'card',
                card: cardElement
            }).then(function (result) {
                if (result.error) {
                    // Handle errors (e.g., invalid card)

                    // Enable the payment button again and reset text
                    paymentButton.prop('disabled', false).text('Pay with Stripe');
                    isPaymentButtonDisabled = false;

                    Swal.fire('Error', result.error.message, 'error');
                } else {
                    // Payment method successfully created, store the ID in the hidden field
                    $('#payment_method').val(result.paymentMethod.id);

                    // Now submit the form to process the payment
                    axios.post('/process-stripe-payment', $('#stripe-payment-form').serialize())
                        .then(function (response) {

                            if (response.data.message) {
                                // Payment successful, show a success message using SweetAlert2
                                Swal.fire('Success', response.data.message, 'success')
                                    .then(function () {
                                        // Close the modal
                                        $('#stripeModal').modal('hide');
                                        setTimeout(function() {
                                            location.reload();
                                        }, 1000);

                                    });
                            } else {
                                // Handle other scenarios if needed
                                Swal.fire('Error', 'An error occurred during payment processing', 'error');
                            }
                        })
                        .catch(function (error) {
                            // Handle payment errors and display error messages
                            Swal.fire('Error', error.response.data.error, 'error');
                        })
                        .finally(function () {
                            // Enable the payment button again and reset text
                            paymentButton.prop('disabled', false).text('Pay with Stripe');
                            isPaymentButtonDisabled = false;

                            // Reset the form
                            $('#stripe-payment-form')[0].reset();
                        });
                }
            });
        });

        // Handle modal show event
        $('#stripeModal').on('show.bs.modal', function () {
            // Clear any existing card data (e.g., previous card number)
            cardElement.clear();
        });

        // Show Stripe modal when the user clicks on the Stripe option
        $('#stripe-option').click(function () {
            $('#stripeModal').modal('show');
        });
    });


    </script>

@endsection
