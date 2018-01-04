<?php
/**
 * donations-free plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace infoservio\donatefast\services;

use craft\base\Component;

use infoservio\donatefast\components\httpClient\stripe\StripeHttpClient;
use infoservio\donatefast\StripeDonation;
use infoservio\donatefast\errors\StripeDonationsPluginException;
use infoservio\donatefast\models\Customer;
use infoservio\donatefast\models\Card;
use infoservio\donatefast\models\Charge;
use infoservio\donatefast\models\Log;

/**
 * Stripe Service
 *
 * @author    infoservio
 * @package   Donationsfree
 * @since     1.0.0
 */
class StripeService extends Component
{
    /** @var StripeHttpClient $object */
    private $_httpClient;

    // Public Methods
    // =========================================================================
    public function init()
    {
        parent::init();
        $this->_httpClient = StripeDonation::$PLUGIN->stripeClient;
    }


    /**
     * @param Customer $customer
     * @param string $token
     * @return \Stripe\Customer
     * @throws StripeDonationsPluginException
     */
    public function createCustomer(Customer &$customer, string $token)
    {
        $result = $this->_httpClient->createCustomer($customer, $token);

        if (!isset($result->id)) {
            throw new StripeDonationsPluginException(
                $result->errors->deepAll(),
                $result->message,
                __METHOD__,
                Log::CUSTOMER_LOGS
            );
        }

        $customer->customerId = $result->id;
        return $result;
    }

    /**
     * @param Charge $charge
     * @param Card $card
     * @param Customer $customer
     * @return mixed
     * @throws StripeDonationsPluginException
     */
    public function createCharge(Charge &$charge, Card &$card, Customer $customer)
    {
        $result = $this->_httpClient->createCharge($customer, $charge);

        if (!isset($result->id)) {
            throw new StripeDonationsPluginException(
                $result->errors->deepAll(),
                $result->message,
                __METHOD__,
                Log::CHARGE_LOGS
            );
        }

        // Set up card
        $card->tokenId = $result->source->id;
        $card->cardType = $result->source->brand;
        $card->last4 = $result->source->last4;
        $card->expMonth = $result->source->exp_month;
        $card->expYear = $result->source->exp_year;
        $card->fingerprint = $result->source->fingerprint;
        $card->customerLocation = $result->source->country;

        // Set up charge
        $charge->chargeId = $result->id;
        $charge->amount = $result->amount;
        $charge->amountRefunded = $result->amount_refunded;
        $charge->balanceTransaction = $result->balance_transaction;
        $charge->currency = $result->currency;
        $charge->created = $result->created;
        $charge->fraudDetails = json_encode($result->fraud_details);
        $charge->failureCode = $result->failure_code;
        $charge->failureMessage = $result->failure_message;

        return $result;
    }
}
