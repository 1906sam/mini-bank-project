<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ClientDetail Entity
 *
 * @property int $id
 * @property string $client_name
 * @property int $mobile
 * @property string $introducer_person
 * @property string $client_photo
 * @property string $client_sign_photo
 * @property int $status
 * @property \Cake\I18n\Time $created_date
 * @property \Cake\I18n\Time $modified_date
 */
class ClientDetail extends Entity
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
