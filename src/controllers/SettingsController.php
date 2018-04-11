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
use craft\web\Controller;
use infoservio\donatefast\DonateFast;
use infoservio\donatefast\models\StripeDonationSetting;

/**
 * Settings Controller
 *
 * https://craftcms.com/docs/plugins/controllers
 *
 * @author    infoservio
 * @package   Donationsfree
 * @since     1.0.0
 */
class SettingsController extends BaseController
{
    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = [];

    public function actionSettings()
    {
        if ($post = Craft::$app->request->post()) {
            DonateFast::$plugin->pluginService->update($post);
            return $this->redirect('donate-fast/settings');
        }

        $settings = StripeDonationSetting::getSettingsArr();
        return $this->renderTemplate('donate-fast/settings/index', [
            'settings' => $settings,
            'isUserHelpUs' => $this->isUserHelpUs
        ]);
    }

//    public function actionDonationForm()
//    {
//        return $this->renderTemplate('donate-fast/settings/donation-form', [
//            'isUserHelpUs' => $this->isUserHelpUs
//        ]);
//    }
}
