<?php

namespace infoservio\donatefast\services;

use Craft;
use craft\base\Component;

use craft\mail\Message;
use infoservio\donatefast\errors\StripeDonationsPluginException;
use infoservio\donatefast\models\StripeDonationSetting;
use infoservio\donatefast\DonateFast;
use infoservio\donatefast\models\Customer as CustomerModel;
use infoservio\donatefast\models\Card as CardModel;
use infoservio\donatefast\models\Charge as ChargeModel;

class DonationService extends Component
{

    const TEMPLATE_PATH = __DIR__ . '/../views/success-donation.html';
    // Public Methods
    // =========================================================================

    /**
     * @param array $params
     * @throws StripeDonationsPluginException
     */
    public function donate(array $params)
    {
        try {
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
                $this->sendEmail($settings, $customer, $charge);
            }
        } catch (\Exception $e) {
            die(json_encode([$e->getMessage(), $e->getTraceAsString()]));
        }
    }

    /**
     * @param $settings
     * @param $customer
     * @param $charge
     */
    private function sendEmail($settings, $customer, $charge): void
    {
        $template = file_get_contents(self::TEMPLATE_PATH);
        $template = str_replace('{companyName}', $settings['companyName'], $template);
        $template = str_replace('{companyAddress}', $settings['companyAddress'], $template);
        $template = str_replace('{companyTelephone}', $settings['companyTelephone'], $template);
        $template = str_replace('{companyEmail}', $settings['companyEmail'], $template);
        $template = str_replace('{userEmail}', $customer->email, $template);
        $template = str_replace('{invoiceId}', $charge->chargeId, $template);
        $template = str_replace('{invoiceDate}', $charge->dateCreated, $template);
        $template = str_replace('{invoiceDescription}', $charge->projectId . ' - ' . $charge->projectName, $template);
        $template = str_replace('{invoiceSum}', $charge->amount, $template);

        $message = (new Message())
            ->setReplyTo($settings['companyEmail'])
            ->setTo($customer->email)
            ->setSubject('Successful donation for ' . $charge->projectName)
            ->setHtmlBody($template);

        Craft::$app->getMailer()->send($message);
    }
}
