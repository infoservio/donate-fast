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
use infoservio\mailmanager\MailManager;
use infoservio\donatefast\models\StripeDonationSetting;
use infoservio\donatefast\records\Charge;
use infoservio\mailmanager\records\Template as TemplateRecord;
use infoservio\donatefast\DonateFast;
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
        $this->isUserHelpUs = DonateFast::$PLUGIN->getSettings()->helpUsImproveOurProduct;
        return parent::beforeAction($action);
    }
}
