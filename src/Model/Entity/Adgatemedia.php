<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Adgatemedia Entity
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $requirements
 * @property string|null $description
 * @property string $epc
 * @property string|null $click_url
 * @property \Cake\I18n\FrozenDate $created
 * @property \Cake\I18n\FrozenDate $modified
 */
class Adgatemedia extends Entity
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
        'name' => true,
        'requirements' => true,
        'description' => true,
        'epc' => true,
        'click_url' => true,
        'created' => true,
        'modified' => true,
    ];
}
