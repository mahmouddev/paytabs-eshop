<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrdersFixture
 */
class OrdersFixture extends TestFixture
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
                'user_id' => 1,
                'cart_id' => 'Lorem ipsum dolor sit amet',
                'guest_email' => 'Lorem ipsum dolor sit amet',
                'guest_name' => 'Lorem ipsum dolor sit amet',
                'guest_phone' => 'Lorem ipsum dolor sit amet',
                'status' => 'Lorem ipsum dolor sit amet',
                'total' => 1.5,
                'delivery_method' => 'Lorem ipsum dolor sit amet',
                'shipping_address' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'pickup_location' => 'Lorem ipsum dolor sit amet',
                'created' => '2024-12-21 22:23:44',
                'modified' => '2024-12-21 22:23:44',
            ],
        ];
        parent::init();
    }
}
