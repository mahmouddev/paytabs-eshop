<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateOrders extends BaseMigration
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
        $table = $this->table('orders');
        $table
            ->addColumn('user_id', 'integer', ['null' => true]) // Nullable for guest users
            ->addColumn('cart_id', 'string', ['limit' => 255]) // For guest cart id
            ->addColumn('guest_email', 'string', ['limit' => 255, 'null' => true]) // For guest users
            ->addColumn('guest_name', 'string', ['limit' => 255, 'null' => true])  // For guest name
            ->addColumn('guest_phone', 'string', ['limit' => 50, 'null' => true])  // Optional guest phone
            ->addColumn('status', 'string', ['limit' => 50, 'default' => 'pending'])
            ->addColumn('total', 'decimal', ['precision' => 10, 'scale' => 2])
            ->addColumn('delivery_method', 'string', ['limit' => 50, 'default' => 'shipping']) // 'shipping' or 'pickup'
            ->addColumn('shipping_address', 'text', ['null' => true]) // Shipping address
            ->addColumn('pickup_location', 'string', ['limit' => 255, 'null' => true]) // Pickup location
            ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('modified', 'datetime', ['null' => true])
            ->create();
    }
}
