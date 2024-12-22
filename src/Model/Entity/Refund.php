<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Refund Entity
 *
 * @property int $id
 * @property int $order_id
 * @property string|null $refund_request
 * @property string|null $refund_response
 * @property string $amount
 * @property string $status
 * @property \Cake\I18n\DateTime $created
 *
 * @property \App\Model\Entity\Order $order
 */
class Refund extends Entity
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
        'order_id' => true,
        'refund_request' => true,
        'refund_response' => true,
        'amount' => true,
        'status' => true,
        'created' => true,
        'order' => true,
    ];
}
