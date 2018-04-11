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

use infoservio\donatefast\DonateFast;

use Craft;
use infoservio\donatefast\records\StripeDonationSetting;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

/**
 * Donation Controller
 *
 * @author    infoservio
 * @package   Donationsfree
 * @since     1.0.0
 */
class DonationController extends BaseController
{
    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['donate', 'success', 'error'];

    // Public Methods
    // =========================================================================

    public function actionSuccess()
    {
        $view = $this->getView();
        $view->setTemplatesPath($this->getViewPath());

        $successMessage = StripeDonationSetting::find()->where(['name' => 'successMessage'])->one()->value;
        $resetForm = Craft::$app->session->get('donation');

        return $this->renderTemplate('donation-success', [
            'baseUrl' => $resetForm['currentUrl'],
            'successMessage' => $successMessage,
            'resetForm' => $resetForm,
        ]);
    }

    public function actionError()
    {
        $view = $this->getView();
        $view->setTemplatesPath($this->getViewPath());
        $resetForm = Craft::$app->session->get('donation');

        try {
            $errorMessage = StripeDonationSetting::find()->where(['name' => 'errorMessage'])->one()->value;

            return $this->renderTemplate('donation-error', [
                'errorMessage' => $errorMessage,
                'baseUrl' => $resetForm['currentUrl']
            ]);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * @return \yii\web\Response
     * @throws \yii\web\BadRequestHttpException
     */
    public function actionDonate()
    {
        $this->requirePostRequest();
        $post = Craft::$app->request->getBodyParams();

        $view = $this->getView();
        $view->setTemplatesPath($this->getViewPath());

        if (!isset($post['amount']) || !$post['amount']) {

            return $this->renderTemplate('donation-error', [
                'errorMessage' => 'Something went wrong. Donation amount is empty. Please write to us.'
            ]);
        }

        if (!isset($post['stripeEmail']) || !$post['stripeEmail']) {

            return $this->renderTemplate('donation-error', [
                'errorMessage' => 'Donating wasn\'t set up properly. Please write to us.'
            ]);
        }

        Craft::$app->session->set('donation', $post);
        try {
            DonateFast::$plugin->donation->donate($post);
        } catch (\Exception $e) {
            return $this->redirect('/donate-fast/error');
        }

        return $this->redirect('/donate-fast/success');
    }
}
