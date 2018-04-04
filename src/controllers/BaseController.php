<?php

namespace infoservio\donatefast\controllers;

use Craft;
use craft\web\Controller;
use infoservio\donatefast\DonateFast;

class BaseController extends Controller
{
    public $isUserHelpUs = false;

    // Public Methods
    // =========================================================================

    public function beforeAction($action)
    {
        Craft::$app->response->format = \yii\web\Response::FORMAT_JSON;
        // ...set `$this->enableCsrfValidation` here based on some conditions...
        // call parent method that will check CSRF if such property is true.
        $this->enableCsrfValidation = false;
        $this->isUserHelpUs = DonateFast::$plugin->getSettings()->helpUsImproveOurProduct;
        return parent::beforeAction($action);
    }
}
