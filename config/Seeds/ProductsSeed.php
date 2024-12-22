<?php
declare(strict_types=1);

use Migrations\BaseSeed;

/**
 * ProductsSeed seed.
 */
class ProductsSeed extends BaseSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/migrations/4/en/seeding.html
     *
     * @return void
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Fresh Avocado Juice',
                'category' => 'Juices',
                'price' => 15.50,
                'quantity' => 10,
                'rating' => 4.2,
                'image' => 'images/thumb-avocado.png',
            ],
            [
                'name' => 'Crunchy Choco Biscuits',
                'category' => 'Biscuits',
                'price' => 12.00,
                'quantity' => 25,
                'rating' => 4.8,
                'image' => 'images/thumb-biscuits.png',
            ],
            [
                'name' => 'Organic Cucumber',
                'category' => 'Fruits & Veges',
                'price' => 5.00,
                'quantity' => 50,
                'rating' => 4.5,
                'image' => 'images/thumb-cucumber.png',
            ],
            [
                'name' => 'Fresh Dairy Milk',
                'category' => 'Dairy',
                'price' => 10.75,
                'quantity' => 20,
                'rating' => 4.9,
                'image' => 'images/thumb-milk.png',
            ],
            [
                'name' => 'Orange Juice',
                'category' => 'Juices',
                'price' => 16.00,
                'quantity' => 15,
                'rating' => 4.7,
                'image' => 'images/thumb-orange-juice.png',
            ],
            [
                'name' => 'Raspberries Delight',
                'category' => 'Fruits',
                'price' => 25.00,
                'quantity' => 30,
                'rating' => 4.3,
                'image' => 'images/thumb-raspberries.png',
            ],
            [
                'name' => 'Cherry Tomatoes',
                'category' => 'Vegetables',
                'price' => 6.50,
                'quantity' => 40,
                'rating' => 4.6,
                'image' => 'images/thumb-tomatoes.png',
            ],
            [
                'name' => 'Spicy Tomato Ketchup',
                'category' => 'Condiments',
                'price' => 8.25,
                'quantity' => 35,
                'rating' => 4.4,
                'image' => 'images/thumb-tomatoketchup.png',
            ],
        ];

        $table = $this->table('products');
        $table->insert($data)->save();

    }
}
