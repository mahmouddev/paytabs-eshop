<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateProducts extends BaseMigration
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
        $table = $this->table('products');
        $table
            ->addColumn('name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('price', 'decimal', ['precision' => 10, 'scale' => 2, 'null' => false])
            ->addColumn('image', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('rating', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('category', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('quantity', 'integer', ['null' => false])
            ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('modified', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->create();
    }
}
