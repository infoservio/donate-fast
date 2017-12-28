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
use infoservio\stripedonation\StripeDonation;
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
class BaseController extends Controller
{
    public $isUserHelpUs = false;

    // Public Methods
    // =========================================================================

    public function beforeAction($action)
    {
        // ...set `$this->enableCsrfValidation` here based on some conditions...
        // call parent method that will check CSRF if such property is true.
        $this->enableCsrfValidation = false;
        $this->isUserHelpUs = StripeDonation::$PLUGIN->getSettings()->helpUsImproveOurProduct;
        return parent::beforeAction($action);
    }
}
