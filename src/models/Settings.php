<?php

namespace infoservio\donatefast\models;

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

    public $stripeSecretKey = 'sk_test_238KrMHPdX3dQbQDOaO0lODo';
    public $stripePublishableKey = 'pk_test_uBbZUnxUMQ8BPLLMI2aSCoct';
    public $helpUsImproveOurProduct = false;
    public $sendStripeEmailReceipt = false;

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
