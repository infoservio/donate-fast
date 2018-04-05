<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 05.04.18
 * Time: 16:48
 */

namespace infoservio\donatefast\services;

use Craft;
use craft\mail\Message;
use infoservio\donatefast\components\TemplateParser;

class SendEmailService
{
    public function send($settings, $customer, $charge)
    {
        $template = TemplateParser::parseReceiptTemplate($settings, $customer, $charge);

        $message = (new Message())
            ->setReplyTo($settings['companyEmail'])
            ->setTo($customer->email)
            ->setSubject('Successful donation for ' . $charge->projectName)
            ->setHtmlBody($template);

        return Craft::$app->getMailer()->send($message);
    }
}