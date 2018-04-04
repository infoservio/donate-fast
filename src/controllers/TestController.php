<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 04.04.18
 * Time: 12:10
 */

namespace infoservio\donatefast\controllers;

use infoservio\donatefast\DonateFast;
use infoservio\donatefast\errors\StripeDonationsPluginException;

class TestController extends BaseController
{
    protected $allowAnonymous = ['index'];

    public function actionIndex()
    {
        try {
            return DonateFast::$plugin->donation->donate([]);
        } catch (StripeDonationsPluginException $e) {
            die($e->getMessage());
        }
    }
}