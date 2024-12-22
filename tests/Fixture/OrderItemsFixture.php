<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrderItemsFixture
 */
class OrderItemsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'order_id' => 1,
                'product_id' => 1,
                'quantity' => 1,
                'refunded_quantity' => 1,
                'price' => 1.5,
                'subtotal' => 1.5,
                'created' => '2024-12-21 22:24:00',
            ],
        ];
        parent::init();
    }
}
