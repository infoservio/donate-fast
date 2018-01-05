<?php
/**
 * donations-free plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace infoservio\donatefast\controllers;

use Craft;
use infoservio\fastsendnote\FastSendNote;
use infoservio\donatefast\models\StripeDonationSetting;
use infoservio\donatefast\records\Charge;
use infoservio\fastsendnote\records\Template as TemplateRecord;
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
class InvoiceController extends BaseController
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

    /**
     * @return \yii\web\Response
     */
    public function actionIndex()
    {
        $columns = Charge::getColumns();
        $records = Charge::getAll();
        return $this->renderTemplate('donate-fast/invoice/index', [
            'columns' => $columns,
            'records' => $records,
            'isUserHelpUs' => $this->isUserHelpUs,
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
            return $this->redirect('donate-fast/not-found');
        }

        $card = $record->getCard();
        $customer = $card->getCustomer();
        $settings = StripeDonationSetting::getSettingsArr();
        $template = TemplateRecord::getBySlug('success-donation');
        $parsedTemplate = FastSendNote::$plugin->templateParser->parse($template->template, [
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

        return $this->renderTemplate('donate-fast/invoice/view', [
            'template' => $parsedTemplate,
            'isUserHelpUs' => $this->isUserHelpUs
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
            return $this->redirect('donate-fast/not-found');
        }

        $card = $record->getCard();
        $customer = $card->getCustomer();
        $settings = StripeDonationSetting::getSettingsArr();
        return FastSendNote::$plugin->mail->send($customer->email, 'success-donation', [
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
