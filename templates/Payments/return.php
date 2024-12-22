<?php if(in_array($postData['respStatus'] , ['A' , 'V']) ) {?>
<div class="container py-5 text-center">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="alert alert-success" role="alert">
                <h1 class="display-4">
                    <i class="fas fa-check-circle"></i> Payment Successful!
                </h1>
                <p class="lead">Thank you for your order. Your payment was processed successfully.</p>
            </div>
            <div class="order-summary">
                <h3 class="mb-4">
                    <i class="fas fa-receipt"></i> Order Summary
                </h3>
                <ul class="list-group mb-3">
                    <?php foreach ($order->order_items as $item): ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <div>
                                <strong><?= h($item->product->name); ?></strong>
                                <small class="text-muted d-block">x<?= $item->quantity; ?></small>
                            </div>
                            <span class="text-muted">$<?= number_format($item->price * $item->quantity, 2); ?></span>
                        </li>
                    <?php endforeach; ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>Total</strong>
                        <span class="fw-bold">$<?= number_format($order->total, 2); ?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php } else { ?>
    <div class="container py-5 text-center">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="alert alert-danger" role="alert">
                <h1 class="display-4">
                    <i class="fas fa-times-circle"></i> Payment Failed
                </h1>
                <p class="lead">We encountered an issue processing your payment. Please try again.</p>
            </div>
            <p class="mb-4">If the issue persists, please contact our support team for assistance.</p>
        </div>
    </div>
</div>

<?php } ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        let cartStatus = <?= json_encode(in_array($postData['respStatus'], ['A', 'V'])); ?>;
        if(cartStatus){
            localStorage.setItem('cart' , []);
        }
    });

</script>
