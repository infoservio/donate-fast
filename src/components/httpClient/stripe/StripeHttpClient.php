<?php

namespace infoservio\donatefast\components\httpClient\stripe;

use infoservio\donatefast\DonateFast;
use yii\base\Component;

use Stripe\Customer as StripeCustomer;
use Stripe\Charge as StripeCharge;
use Stripe\Stripe;

use infoservio\donatefast\models\Customer;
use infoservio\donatefast\models\Charge;

class StripeHttpClient extends Component
{
    private $_channel = 'endure_SP_BT';
    private $_settings;

    function __construct()
    {
        parent::__construct();
        $this->_settings = DonateFast::$plugin->getSettings();

        // Configuration of Stripe
        Stripe::setApiKey($this->_settings->stripeSecretKey);
    }

    // Public Methods
    // =========================================================================

    /**
     * @param Customer $customer
     * @param string $stripeToken
     * @return StripeCustomer
     */
    public function createCustomer(Customer $customer, string $stripeToken)
    {
        $result = StripeCustomer::create([
            'email' => $customer->email,
            'description' => $customer->description,
            'source' => $stripeToken
        ]);

        return $result;
    }

    /**
     * @param Customer $customer
     * @param Charge $charge
     * @param bool $sendStripeEmailReceipt
     * @return StripeCharge
     */
    public function createCharge(Customer $customer, Charge $charge, bool $sendStripeEmailReceipt = false)
    {
        $params = [
            'amount' => $charge->amount * 100,
            "currency" => "usd",
            'customer' => $customer->customerId,
            'metadata' => [
                'projectId' => $charge->projectId,
                'projectName' => $charge->projectName
            ]
        ];

        if ($sendStripeEmailReceipt) {
            $params['receipt_email'] = $customer->email;
        }

        $result = StripeCharge::create($params);

        return $result;
    }

    /**
     * @param string $stripeToken
     * @return StripeCharge
     */
    public function createTestCharge(string $stripeToken)
    {
        $result = StripeCharge::create([
            'amount' => '10.00',
            'currency' => 'usd',
            'source' => $stripeToken
        ]);

        return $result;
    }
}
