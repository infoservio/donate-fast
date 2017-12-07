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
 * Customer Model
 *
 * @author    endurant
 * @package   Donationsfree
 * @since     1.0.0
 */
class Customer extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * Some model attribute
     *
     * @var string
     */
    public $id;
    public $customerId;
    public $email;
    public $phone;
    public $description;

    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes.
     * @return array
     */
    public function rules()
    {
        return [
            ['customerId', 'string', 'max' => 36],
            [['email', 'phone'], 'string', 'max' => 50],
            ['description', 'string', 'max' => 255],
            ['email', 'email'],
            [['customerId', 'email'], 'required']
        ];
    }

    public static function create(array $params)
    {
        $customer = new self();
        $customer->email = $params['email'];
        $customer->phone = $params['phone'];

        return $customer;
    }
}
