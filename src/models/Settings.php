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
 * Settings Model
 *
 * @author    endurant
 * @package   Donationsfree
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    public $stripeSecretKey = 'sk_test_BQokikJOvBiI2HlWgH4olfQ2';
    public $stripePublishableKey = 'pk_test_6pRNASCoBOKtIshFeQd4XMUh';

    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['stripeSecretKey', 'stripePublishableKey'], 'string'],
            [['stripeSecretKey', 'stripePublishableKey'], 'required'],
        ];
    }
}
