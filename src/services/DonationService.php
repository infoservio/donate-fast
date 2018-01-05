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

use infoservio\fastsendnote\FastSendNote;
use infoservio\donatefast\errors\StripeDonationsPluginException;
use infoservio\donatefast\models\StripeDonationSetting;
use infoservio\donatefast\DonateFast;
use infoservio\donatefast\models\Customer;
use infoservio\donatefast\models\Card;
use infoservio\donatefast\models\Charge;

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
        $settings = StripeDonationSetting::getSettingsArr();

        $plugin = DonateFast::$PLUGIN;
        $customer = Customer::create($params);
        $card = new Card();
        $charge = new Charge();
        $charge->amount = intval($params['amount']) * 100;
        $charge->projectId = intval($params['projectId']);
        $charge->projectName = $params['projectName'];
        $charge->clientIp = $params['stripeClientIP'];

        $stripeService = $plugin->stripe;

        $stripeService->createCustomer($customer, $params['stripeToken']);
        $stripeService->createCharge($charge, $card, $customer, $plugin->getSettings()->sendStripeEmailReceipt);

        try {
            $customer = $plugin->customer->save($customer);
            $card->customerId = $customer->id;
            $card = $plugin->card->save($card);
            $charge->cardId = $card->id;
            $charge = $plugin->charge->save($charge);
        } catch (\Exception $e) {
            // test
        }

        // sending email
        if(!$plugin->getSettings()->sendStripeEmailReceipt) {
            FastSendNote::$plugin->mail->send($customer->email, 'success-donation', [
                'companyName' => $settings['companyName'],
                'companyAddress' => $settings['companyAddress'],
                'companyTelephone' => $settings['companyTelephone'],
                'companyEmail' => $settings['companyEmail'],
                'userName' => 'Not Found',
                'userAddress' => 'Not Found',
                'userEmail' => $customer->email,
                'invoiceId' => $charge->chargeId,
                'invoiceDescription' => $charge->projectName,
                'invoiceSum' => $charge->amount / 100,
                'invoiceDate' => $charge->created
            ], $charge->chargeId);
        }
    }
}
