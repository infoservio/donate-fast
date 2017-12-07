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
 * Card Model
 *
 * @author    endurant
 * @package   Donationsfree
 * @since     1.0.0
 */
class Log extends Model
{
    // Public Properties
    // =========================================================================
    const CARD_LOGS = 'card-logs';
    const CUSTOMER_LOGS = 'customer-logs';
    const CHARGE_LOGS = 'charge-logs';

    const STRIPE_CULPRIT = ['id' => 1, 'name' => 'stripe'];
    const DB_CULPRIT = ['id' => 2, 'name' => 'db'];
    /**
     * Some model attribute
     *
     * @var string
     */
    public $id;
    public $pid;
    public $culprit;
    public $category;
    public $method;
    public $errors;
    public $message;

    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes.
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'pid', 'culprit'], 'integer'],
            [['method', 'errors', 'message', 'category'], 'string'],
            [['pid', 'method', 'errors', 'message'], 'required']
        ];
    }
}
