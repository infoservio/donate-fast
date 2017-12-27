<?php
/**
 * donations-free plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace infoservio\stripedonation\services;

use craft\base\Component;

use infoservio\mailmanager\MailManager;
use infoservio\stripedonation\errors\StripeDonationsPluginException;
use infoservio\stripedonation\StripeDonation;
use infoservio\stripedonation\errors\DbDonationsPluginException;
use infoservio\stripedonation\models\Customer;
use infoservio\stripedonation\models\Card;
use infoservio\stripedonation\models\Charge;

/**
 * Donation Service
 *
 * @author    infoservio
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
        $charge->amount = intval($params['fixedAmount']);
        $charge->projectId = intval($params['projectId']);
        $charge->projectName = $params['projectName'];

        $stripeService = $plugin->stripe;

        $stripeService->createCustomer($customer, $params['stripeToken']);
        $stripeService->createCharge($charge, $card, $customer);

        // sending email
        MailManager::$PLUGIN->mail->send($customer->email, 'success-donation', [
            'companyName' => '',
            'companyTelephone' => '',
            'companyEmail' => '',
            'userName' => '',
            'userAddress' => '',
            'userEmail' => '',
            'invoiceId' => '',
            'invoiceDescription' => '',
            'invoiceSum' => ''
        ], $charge->chargeId);

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
