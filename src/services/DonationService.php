<?php
/**
 * donations-free plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace endurant\stripedonation\services;

use endurant\stripedonation\errors\StripeDonationsPluginException;
use endurant\stripedonation\StripeDonation;

use craft\base\Component;

use endurant\stripedonation\errors\DbDonationsPluginException;
use endurant\stripedonation\models\Customer;
use endurant\stripedonation\models\Card;
use endurant\stripedonation\models\Charge;

/**
 * Donation Service
 *
 * @author    endurant
 * @package   Donationsfree
 * @since     1.0.0
 */
class DonationService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * @param array $params
     * @throws StripeDonationsPluginException
     */
    public function donate(array $params)
    {
        $plugin = StripeDonation::$PLUGIN;
        $customer = Customer::create($params);
        $card = new Card();
        $charge = new Charge();
        $charge->amount = intval($params['amount']);
        $charge->projectId = intval($params['projectId']);
        $charge->projectName = $params['projectName'];

        $stripeService = $plugin->stripe;

        $stripeService->createCustomer($customer, $params['nonce']);
        $stripeService->createCharge($charge, $card, $customer);

       try {
            $customer = $plugin->customer->save($customer);
            $card->customerId = $customer->id;
            $card = $plugin->card->save($card);
            $charge->cardId = $card->id;
            $charge = $plugin->charge->save($charge);
       } catch(DbDonationsPluginException $e) {
           
       }
    }
}
