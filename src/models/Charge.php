<?php
/**
 * donations-free plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace endurant\stripedonation\models;

use craft\base\Model;

/**
 * Charge Model
 *
 * @author    endurant
 * @package   Donationsfree
 * @since     1.0.0
 */
class Charge extends Model
{
    // Public Properties
    // =========================================================================

    public $id;
    public $chargeId;
    public $cardId;
    public $amount;
    public $amountRefunded;
    public $balanceTransaction;
    public $currency;
    public $projectId;
    public $projectName;
    public $fraudDetails;
    public $failureCode;
    public $failureMessage;
    public $created;

    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes.
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'cardId', 'projectId', 'created'], 'integer'],
            [['amount', 'amountRefunded'], 'double'],
            ['currency', 'string', 'max' => 10],
            [['changeId', 'balanceTransaction'], 'string', 'max' => 50],
            [['projectName', 'failureCode'], 'string', 'max' => 50],
            [['fraudDetails', 'failureMessage'], 'string'],
            [['cardId', 'chargeId', 'amount'], 'required']
        ];
    }
}
