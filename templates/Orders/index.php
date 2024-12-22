<div class="container py-5">
    <div class="row">
    <h3 class="mb-4">My Orders</h3>
    <div class="list-group">
        <!-- Example List Items -->
        <?php foreach ($orders as $order): ?>
        <div class="list-group-item list-group-item-action mb-2 shadow-sm">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1"><i class="fas fa-box"></i> Order #<?= h($order->id) ?></h5>
                    <p class="mb-0 text-muted">
                        <i class="fas fa-calendar"></i> <?= h($order->created) ?>
                        | <i class="fas fa-dollar-sign"></i><?= h($order->total) ?>
                    </p>
                </div>
                <div>
                    <span class="badge bg-<?= $order->status === 'paid' ? 'success' : 'warning' ?>">
                        <?= ucfirst(h($order->status)) ?>
                    </span>
                </div>
            </div>
            <div class="mt-2">
                <a href="<?= $this->Url->build(['controller' => 'Orders', 'action' => 'view', $order->id]) ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-eye"></i> View Details
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <!-- Pagination -->
    <nav class="mt-4 d-flex justify-content-center">
        <?= $this->Paginator->prev('<i class="fas fa-arrow-left"></i> Previous', [
            'escape' => false,
            'class' => 'btn btn-secondary btn-sm mx-2'
        ]) ?>
        <?= $this->Paginator->numbers([
            'class' => 'pagination pagination-sm',
            'tag' => 'span',
            'currentTag' => 'span',
            'currentClass' => 'badge bg-primary',
            'separator' => ''
        ]) ?>
        <?= $this->Paginator->next('Next <i class="fas fa-arrow-right"></i>', [
            'escape' => false,
            'class' => 'btn btn-secondary btn-sm mx-2'
        ]) ?>
    </nav>
    </div>
</div>
