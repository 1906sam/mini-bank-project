<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ClientRd Entity
 *
 * @property int $id
 * @property int $client_id
 * @property int $rd_amount
 * @property int $rate_of_interest
 * @property int $time_duration
 * @property int $status
 * @property \Cake\I18n\Time $created_date
 * @property int $modified_date
 *
 * @property \App\Model\Entity\ClientDetail $client_detail
 * @property \App\Model\Entity\ClientRdPayment[] $client_rd_payments
 */
class ClientRd extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
