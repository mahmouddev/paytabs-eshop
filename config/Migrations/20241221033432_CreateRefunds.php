<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateRefunds extends BaseMigration
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
        $table = $this->table('refunds');
        $table
            ->addColumn('order_id', 'integer', ['null' => false]) // Foreign key to orders
            ->addColumn('refund_request', 'text', ['null' => true]) // Refund request payload
            ->addColumn('refund_response', 'text', ['null' => true]) // Refund response payload
            ->addColumn('amount', 'decimal', ['precision' => 10, 'scale' => 2]) // Refund amount
            ->addColumn('status', 'string', ['limit' => 50, 'default' => 'pending']) // Refund status
            ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP']) // Creation timestamp
            ->addForeignKey('order_id', 'orders', 'id', ['delete' => 'CASCADE']) // FK to orders
            ->create();
    }
}
