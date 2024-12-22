<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateOrderItems extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('order_items');
        $table
            ->addColumn('order_id', 'integer', ['null' => false])
            ->addColumn('product_id', 'integer', ['null' => false])
            ->addColumn('quantity', 'integer', ['default' => 1])
            ->addColumn('refunded_quantity', 'integer', ['default' => 0]) // Tracks how many items have been refunded
            ->addColumn('price', 'decimal', ['precision' => 10, 'scale' => 2])
            ->addColumn('subtotal', 'decimal', ['precision' => 10, 'scale' => 2]) // quantity * price
            ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addForeignKey('order_id', 'orders', 'id', ['delete' => 'CASCADE'])
            ->addForeignKey('product_id', 'products', 'id', ['delete' => 'CASCADE'])
            ->create();
    }
}
