<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\CheckoutController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\CheckoutController Test Case
 *
 * @uses \App\Controller\CheckoutController
 */
class CheckoutControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Checkout',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\CheckoutController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
