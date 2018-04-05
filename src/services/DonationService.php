<?php

namespace infoservio\donatefast\services;

use Craft;
use craft\base\Component;

use craft\mail\Message;
use infoservio\donatefast\components\TemplateParser;
use infoservio\donatefast\errors\StripeDonationsPluginException;
use infoservio\donatefast\models\StripeDonationSetting;
use infoservio\donatefast\DonateFast;
use infoservio\donatefast\models\Customer as CustomerModel;
use infoservio\donatefast\models\Card as CardModel;
use infoservio\donatefast\models\Charge as ChargeModel;

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

        $plugin = DonateFast::$plugin;
        $customer = CustomerModel::create($params);
        $card = new CardModel();
        $charge = new ChargeModel();
        $charge->amount = intval($params['amount']);
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
            die($e->getTraceAsString());
        }

        // sending email
        if (!$plugin->getSettings()->sendStripeEmailReceipt) {
            DonateFast::$plugin->sendEmail->send($settings, $customer, $charge);
        }
    }
}
