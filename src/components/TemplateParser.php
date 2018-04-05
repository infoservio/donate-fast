<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 05.04.18
 * Time: 16:30
 */
namespace infoservio\donatefast\components;

use craft\base\Component;

class TemplateParser extends Component
{
    const TEMPLATE_PATH = __DIR__ . '/../views/success-donation.html';

    public static function parseReceiptTemplate($settings, $customer, $charge)
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
        return $template;
    }
}