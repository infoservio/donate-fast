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

use Craft;
use craft\web\Controller;
use endurant\stripedonation\StripeDonation;
use endurant\stripedonation\models\StripeDonationSetting;

/**
 * Donate Controller
 *
 * https://craftcms.com/docs/plugins/controllers
 *
 * @author    endurant
 * @package   Donationsfree
 * @since     1.0.0
 */
class SettingsController extends Controller
{
    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = [];

    // Public Methods
    // =========================================================================

    public function beforeAction($action)
    {
        // ...set `$this->enableCsrfValidation` here based on some conditions...
        // call parent method that will check CSRF if such property is true.
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionSettings()
    {
        if ($post = Craft::$app->request->post()) {
            StripeDonation::$PLUGIN->plugin->update($post);
            return $this->redirect('stripe-donation/settings');
        }

        $settings = StripeDonationSetting::getSettingsArr();
        return $this->renderTemplate('stripe-donation/settings/index', [
            'settings' => $settings
        ]);
    }

    public function actionDonationForm()
    {
        return $this->renderTemplate('stripe-donation/settings/donation-form');
    }
}
