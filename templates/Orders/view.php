<div class="container py-5">
    <h3 class="mb-4">Order Details</h3>
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark text-white">
            <i class="fas fa-receipt"></i> Order #<?= h($order->id) ?>
        </div>
        <div class="card-body">
            <h5 class="card-title">Order Summary</h5>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <i class="fas fa-calendar"></i> <strong>Date:</strong> <?= h($order->created) ?>
                </li>
                <li class="list-group-item">
                    <i class="fas fa-tag"></i> <strong>Status:</strong>
                    <span class="badge bg-<?= $order->status === 'paid' ? 'success' : 'warning' ?>">
                        <?= ucfirst(h($order->status)) ?>
                    </span>
                </li>
                <li class="list-group-item">
                    <i class="fas fa-dollar-sign"></i> <strong>Total:</strong> $<?= h($order->total) ?>
                </li>
                <li class="list-group-item">
                    <i class="fas fa-truck"></i> <strong>Delivery Method:</strong> <?= h($order->delivery_method) ?>
                </li>
            </ul>
        </div>
    </div>

    <h4>Order Items</h4>
    <div class="list-group">
        <?php foreach ($order->order_items as $item): ?>
        <div class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <h6 class="mb-1"><?= h($item->product->name) ?></h6>
                <p class="mb-0 text-muted">Quantity: <?= h($item->quantity) ?> | Price: $<?= h($item->price) ?></p>
            </div>
            <span>$<?= $item->quantity * $item->price ?></span>
        </div>
        <?php endforeach; ?>
    </div>

    <a href="<?= $this->Url->build(['controller' => 'Orders', 'action' => 'index']) ?>" class="btn btn-secondary mt-3">
        <i class="fas fa-arrow-left"></i> Back to Orders
    </a>
</div>
