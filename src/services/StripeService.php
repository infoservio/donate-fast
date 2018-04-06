<?php

namespace infoservio\donatefast\services;

use craft\base\Component;

use infoservio\donatefast\components\httpClient\stripe\StripeHttpClient;
use infoservio\donatefast\DonateFast;
use infoservio\donatefast\errors\StripeDonationsPluginException;
use infoservio\donatefast\models\Customer as CustomerModel;
use infoservio\donatefast\models\Card as CardModel;
use infoservio\donatefast\models\Charge as ChargeModel;
use infoservio\donatefast\models\Log as LogModel;
use Stripe\Customer;

class StripeService extends Component
{
    /** @var StripeHttpClient $object */
    private $_httpClient;

    // Public Methods
    // =========================================================================
    public function init()
    {
        parent::init();
        $this->_httpClient = DonateFast::$plugin->stripeClient;
    }


    /**
     * @param CustomerModel $customer
     * @param string $token
     * @return Customer
     * @throws StripeDonationsPluginException
     */
    public function createCustomer(CustomerModel &$customer, string $token)
    {
        $result = $this->_httpClient->createCustomer($customer, $token);

        if (!isset($result->id)) {
            throw new StripeDonationsPluginException(
                $result->errors->deepAll(),
                $result->message,
                __METHOD__,
                LogModel::CUSTOMER_LOGS
            );
        }

        $customer->customerId = $result->id;
        return $result;
    }

    /**
     * @param ChargeModel $charge
     * @param CardModel $card
     * @param CustomerModel $customer
     * @param bool $sendStripeEmailReceipt
     * @return mixed
     * @throws StripeDonationsPluginException
     */
    public function createCharge(ChargeModel &$charge, CardModel &$card, CustomerModel $customer, bool $sendStripeEmailReceipt = false)
    {
        $result = $this->_httpClient->createCharge($customer, $charge, $sendStripeEmailReceipt);

        if (!isset($result->id)) {
            throw new StripeDonationsPluginException(
                $result->errors->deepAll(),
                $result->message,
                __METHOD__,
                LogModel::CHARGE_LOGS
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
//        $charge->amount = $result->amount;
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
