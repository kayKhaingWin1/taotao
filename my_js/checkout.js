$(document).ready(function () {

    updateTotals();


    $('#township_id').change(updateTotals);

    $('#checkout-form').submit(function(e) {
        e.preventDefault();
        
        const $form = $(this);
        const $submitBtn = $form.find('button[type="submit"]');
        const $submitText = $submitBtn.find('.submit-text');
        const $spinner = $submitBtn.find('.spinner-border');

        if (!this.checkValidity()) {
            this.reportValidity();
            return;
        }

      
        const formData = {
            township_id: $('#township_id').val(),
            payment_method: $('#payment_method').val(),
            address: $('#address').val().trim(),
            phone: $('#phone').val().trim(),
            delivery_fee: $('#delivery-fee').text().replace(' Ks', '')
        };


        $submitBtn.prop('disabled', true);
        $submitText.text('Processing...');
        $spinner.removeClass('d-none');


        $.ajax({
            url: 'add_order.php',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(formData),
            dataType: 'json', 
            success: function(response) {
                if (response && response.success) {
                    $('.order-card').html(`
                        <div class="text-center py-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="#28a745" class="bi bi-check-circle-fill mb-3" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                            </svg>
                            <h2 class="fw-bold mb-3">Order Placed Successfully!</h2>
                            <p class="lead mb-4">Your order number is: <strong>${response.order_code}</strong></p>
                            <div class="d-flex justify-content-center gap-3">
                                <a href="index.php" class="btn btn-outline-secondary">Continue Shopping</a>
                            </div>
                        </div>
                    `);
                } else {
        
                    showError(response?.message || 'Order submission failed');
                }
            },
            error: function(xhr, status, error) {
                let errorMsg = 'Request failed: ';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg += xhr.responseJSON.message;
                } else {
                    errorMsg += `${xhr.status} ${error}`;
                }
                showError(errorMsg);
            },
            complete: function() {
                $submitBtn.prop('disabled', false);
                $submitText.text('Place Order');
                $spinner.addClass('d-none');
            }
        });
    });


    function updateTotals() {
        const fee = $('#township_id option:selected').data('fee') || 0;
        const subtotal = parseFloat($('#subtotal').data('value'));

        $('#delivery-fee').text(fee.toFixed(2) + ' Ks');
        $('#total-price').text((subtotal + fee).toFixed(2) + ' Ks');
    }

    function showError(message) {

        $('.alert-dismissible').remove();

        $('.order-title').after(`
            <div class="alert alert-danger alert-dismissible fade show">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);

        $('html, body').animate({
            scrollTop: $('.alert-danger').offset().top - 100
        }, 300);
    }
});
