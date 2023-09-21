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
