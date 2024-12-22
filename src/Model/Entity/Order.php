<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Order Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $cart_id
 * @property string|null $guest_email
 * @property string|null $guest_name
 * @property string|null $guest_phone
 * @property string $status
 * @property string $total
 * @property string $delivery_method
 * @property string|null $shipping_address
 * @property string|null $pickup_location
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\OrderItem[] $order_items
 * @property \App\Model\Entity\Payment[] $payments
 * @property \App\Model\Entity\Refund[] $refunds
 */
class Order extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'user_id' => true,
        'cart_id' => true,
        'guest_email' => true,
        'guest_name' => true,
        'guest_phone' => true,
        'status' => true,
        'total' => true,
        'delivery_method' => true,
        'shipping_address' => true,
        'pickup_location' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'order_items' => true,
        'payments' => true,
        'refunds' => true,
    ];
}
