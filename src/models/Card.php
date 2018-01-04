<?php

namespace infoservio\donatefast\models;

use craft\base\Model;

/**
 * Card Model
 *
 * @author    infoservio
 * @package   Donationsfree
 * @since     1.0.0
 */
class Card extends Model
{
    // Public Properties
    // =========================================================================

    public $id;
    public $tokenId;
    public $customerId;
    public $last4;
    public $cardType;
    public $expMonth;
    public $expYear;
    public $customerLocation;
    public $fingerprint;

    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes.
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'customerId', 'expMonth', 'expYear'], 'integer'],
            ['cardType', 'string', 'max' => 20],
            ['tokenId', 'string', 'max' => 50],
            ['customerLocation', 'string', 'length' => 2],
            ['last4', 'string', 'length' => 4],
            ['fingerprint', 'string', 'max' => 36],
            [['tokenId', 'customerId'], 'required']
        ];
    }
}
