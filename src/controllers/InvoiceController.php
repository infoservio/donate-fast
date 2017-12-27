<?php
/**
 * donations-free plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace infoservio\stripedonation\controllers;

use Craft;
use craft\web\Controller;
use infoservio\mailmanager\MailManager;
use infoservio\stripedonation\models\StripeDonationSetting;
use infoservio\stripedonation\records\Charge;
use infoservio\mailmanager\records\Template as TemplateRecord;
use yii\web\BadRequestHttpException;

/**
 * Invoice Controller
 *
 * https://craftcms.com/docs/plugins/controllers
 *
 * @author    infoservio
 * @package   Donationsfree
 * @since     1.0.0
 */
class InvoiceController extends Controller
{
    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['view'];

    // Public Methods
    // =========================================================================

    public function beforeAction($action)
    {
        // ...set `$this->enableCsrfValidation` here based on some conditions...
        // call parent method that will check CSRF if such property is true.
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionIndex()
    {
        $columns = Charge::getColumns();
        $records = Charge::getAll();
        return $this->renderTemplate('stripe-donation/invoice/index', [
            'columns' => $columns,
            'records' => $records,
            'buttons' => ['view', 'send']
        ]);
    }

    /**
     * @return \yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionView()
    {
        $id = Craft::$app->request->getParam('id');
        if (!$id) {
            throw new BadRequestHttpException('Charge ID not found');
        }
        $record = Charge::getById($id);

        if (!$record) {
            return $this->redirect('stripe-donation/not-found');
        }

        $card = $record->getCard();
        $customer = $card->getCustomer();
        $settings = StripeDonationSetting::getSettingsArr();
        $template = TemplateRecord::getBySlug('success-donation');
        $parsedTemplate = MailManager::$PLUGIN->templateParser->parse($template->template, [
            'companyName' => $settings['companyName'],
            'companyAddress' => $settings['companyAddress'],
            'companyTelephone' => $settings['companyTelephone'],
            'companyEmail' => $settings['companyEmail'],
            'userName' => 'Not Found',
            'userAddress' => 'Not Found',
            'userEmail' => $customer->email,
            'invoiceId' => $record->chargeId,
            'invoiceDescription' => $record->projectName,
            'invoiceSum' => $record->amount / 100,
            'invoiceDate' => $record->created
        ]);

        return $this->renderTemplate('stripe-donation/invoice/view', [
            'template' => $parsedTemplate
        ]);
    }

    /**
     * @throws \yii\web\BadRequestHttpException
     */
    public function actionSend()
    {
        $this->requirePostRequest();

        $id = Craft::$app->request->post('id');
        if (!$id) {
            throw new BadRequestHttpException('Charge ID not found');
        }
        $record = Charge::getById($id);

        if (!$record) {
            return $this->redirect('stripe-donation/not-found');
        }

        $card = $record->getCard();
        $customer = $card->getCustomer();
        $settings = StripeDonationSetting::getSettingsArr();
        return MailManager::$PLUGIN->mail->send($customer->email, 'success-donation', [
            'companyName' => $settings['companyName'],
            'companyAddress' => $settings['companyAddress'],
            'companyTelephone' => $settings['companyTelephone'],
            'companyEmail' => $settings['companyEmail'],
            'userName' => 'Not Found',
            'userAddress' => 'Not Found',
            'userEmail' => $customer->email,
            'invoiceId' => $record->chargeId,
            'invoiceDescription' => $record->projectName,
            'invoiceSum' => $record->amount / 100,
            'invoiceDate' => $record->created
        ], $record->chargeId);
    }
}
