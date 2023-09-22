$(document).ready(function() {
    paypal.Buttons({
        createOrder: function(data, actions) {
            // Get the amount from the input field
            var amount = parseFloat($('#paypal-amount').val());

            // Validate the amount (you can add more validation)
            if (isNaN(amount) || amount <= 0) {
                alert('Please enter a valid amount.');
                throw new Error('Invalid amount');
            }

            // Create an order with the entered amount
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: amount.toFixed(2), // Format to two decimal places
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            // Capture the approved payment
            return actions.order.capture().then(function(details) {
                // Handle the successful payment
                // You can display a success message using SweetAlert2
                Swal.fire('Payment completed successfully!', '', 'success');

                // Send transaction data to your server
                var transactionData = {
                    transaction_id: details.id,
                    payment_method: 'PayPal', // Assuming PayPal as the payment method
                    amount: details.purchase_units[0].amount.value,
                    transaction_date: details.create_time,
                    status: 'succeeded' // You can customize this based on your needs
                };

                // Make an AJAX POST request to your server to store the data
                axios.post('/store-transaction', transactionData)
                    .then(function (response) {
                        // Handle the response from your server (e.g., success or error)
                        if (response.data.success) {
                            // You can display a success message here if needed
                        } else {
                            Swal.fire('Error', 'An error occurred while storing the transaction data.', 'error');
                        }
                    })
                    .catch(function (error) {
                        // Handle AJAX request errors
                        Swal.fire('Error', 'An error occurred while sending the transaction data to the server.', 'error');
                        console.error(error);
                    });

                // After successful payment, you may want to refresh the transaction table
                location.reload();
            });
        },
        onError: function(err) {
            // Handle errors
            console.error(err);
            Swal.fire('Error', 'An error occurred while processing the payment.', 'error');
        }
    }).render('#paypal-button-container'); // Render the PayPal button in the specified container

    // Open the PayPal modal when the button is clicked
    $('#paypal-option-button').click(function () {
        $('#paypal-modal').modal('show');
    });
});

