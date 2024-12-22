<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreatePayments extends BaseMigration
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
        $table = $this->table('payments');
        $table
            ->addColumn('order_id', 'integer', ['null' => false])
            ->addColumn('amount', 'decimal', ['precision' => 10, 'scale' => 2])
            ->addColumn('payment_method', 'string', ['limit' => 50]) // e.g., card, cash, etc.
            ->addColumn('status', 'string', ['limit' => 50, 'default' => 'pending'])
            ->addColumn('transaction_id', 'string', ['limit' => 255, 'null' => true]) // Payment gateway ID
            ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addForeignKey('order_id', 'orders', 'id', ['delete' => 'CASCADE'])
            ->create();
    }
}
