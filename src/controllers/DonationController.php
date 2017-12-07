<?php
/**
 * donations-free plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace endurant\stripedonation\controllers;

use endurant\stripedonation\StripeDonation;

use Craft;
use craft\web\Controller;
use craft\helpers\ArrayHelper;
use endurant\stripedonation\assetbundles\bootstrap\StripeDonationBootstrapAssetBundle;
use endurant\stripedonation\errors\DonationsPluginException;
use endurant\stripedonation\models\forms\DonateForm;

use endurant\stripedonation\records\StripeDonationSetting;

/**
 * Donate Controller
 *
 * @author    endurant
 * @package   Donationsfree
 * @since     1.0.0
 */
class DonationController extends Controller
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

    public function beforeAction($action)
    {
        // ...set `$this->enableCsrfValidation` here based on some conditions...
        // call parent method that will check CSRF if such property is true.
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionSuccess()
    {
        $view = $this->getView();

        $view->setTemplatesPath($this->getViewPath());
        // Include all the JS and CSS stuff
        $view->registerAssetBundle(StripeDonationBootstrapAssetBundle::class);

        $successMessage = StripeDonationSetting::find()->where(['name' => 'successMessage'])->one()->value;

        $resetForm = Craft::$app->session->get('donation');

        return $this->renderTemplate('donation-success', [
            'baseUrl' => (Craft::$app->session->get('baseUrl') ? Craft::$app->session->get('baseUrl') : '/'),
            'successMessage' => $successMessage,
            'resetForm' => $resetForm,
        ]);
    }

    public function actionError() 
    {
        $view = $this->getView();

        $view->setTemplatesPath($this->getViewPath());
        // Include all the JS and CSS stuff
        $view->registerAssetBundle(StripeDonationBootstrapAssetBundle::class);

        $errorMessage = StripeDonationSetting::find()->where(['name' => 'errorMessage'])->one()->value;

        return $this->renderTemplate('donation-error', [
            'errorMessage' => $errorMessage,
            'baseUrl' => Craft::$app->session->get('baseUrl') ? Craft::$app->session->get('baseUrl') : '/'
        ]);
    }


    /**
     * @return \yii\web\Response
     * @throws \yii\web\BadRequestHttpException
     */
    public function actionDonate()
    {
        $this->requirePostRequest();
        $post = Craft::$app->request->getBodyParams();
//        die(json_encode($post));
        try {
            StripeDonation::$PLUGIN->donation->donate($post);
        } catch (DonationsPluginException $e) {
            return $this->redirect('/actions/stripe-donation/donation/error');
        } catch (\Error $e) {
            return $this->redirect('/actions/stripe-donation/donation/error');
        }

        Craft::$app->session->set('donation', $post);
        return $this->redirect('/actions/stripe-donation/donation/success');
    }
}
