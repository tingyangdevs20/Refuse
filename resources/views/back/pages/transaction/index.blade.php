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
                                    <a href="#" class="text-decoration-none" data-toggle="modal" data-target="#stripeModal">
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
                                                    <th>Date</th>
                                                    <th>Description</th>
                                                    <th class="highlight-column">Amount</th>
                                                    <th>Token</th>
                                                    <th>Title</th>
                                                    <th>Platform</th>
                                                    <th>Transaction Date</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- @foreach($transactions as $transaction)
                                                    <tr>
                                                        <td>{{ $transaction->created_at->format('Y-m-d') }}</td>
                                                        <td>{{ $transaction->description }}</td>
                                                        <td class="highlight-column">${{ number_format($transaction->amount, 2) }}</td>
                                                        <td>{{ $transaction->token }}</td>
                                                        <td>{{ $transaction->title }}</td>
                                                        <td>{{ $transaction->platform }}</td>
                                                        <td>{{ $transaction->transaction_date }}</td>
                                                        <td>{{ $transaction->status }}</td>
                                                    </tr>
                                                @endforeach --}}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- container-fluid -->
</div>

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
                <!-- Payment form inputs -->
                <form id="paymentForm" action="{{ route('payment.process') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="amount">Amount ($):</label>
                        <input type="number" class="form-control" id="amount" name="amount" min="5" required>
                    </div>
                    <div id="card-element">
                        <!-- Stripe Elements will be displayed here -->
                    </div>
                    <button id="submit-button" class="btn btn-primary">Pay Now</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="confirmStripePayment">Confirm Payment</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>
        $(document).ready(function () {
            $('#datatable').DataTable();
        });
    </script>

<script>
    $(document).ready(function () {
        $('#confirmStripePayment').click(function () {
            // Validate the amount (greater than or equal to 5)
            const amount = parseFloat($('#amount').val());
            if (amount < 5) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Amount must be greater than $5',
                });
                return;
            }

            // Perform any additional validation here (e.g., cardNumber, expDate, cvc)

            // Show a confirmation SweetAlert
            Swal.fire({
                title: 'Confirm Payment',
                text: 'Are you sure you want to make this payment?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, make the payment',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Perform Stripe payment processing here
                    // You can use the Stripe.js library to handle the payment

                    // Once the payment is successful, you can close the modal
                    $('#stripeModal').modal('hide');

                    // Optionally, show a success SweetAlert
                    Swal.fire({
                        icon: 'success',
                        title: 'Payment Successful',
                        text: 'Your payment has been processed successfully.',
                    });
                }
            });
        });
    });
</script>
@endsection
