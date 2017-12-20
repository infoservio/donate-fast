<?php

namespace infoservio\stripedonation\models;

use craft\base\Model;

/**
 * Settings Model
 *
 * @author    infoservio
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
