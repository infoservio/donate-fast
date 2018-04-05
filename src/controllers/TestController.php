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
            return DonateFast::$plugin->donation->donate([
                "projectId" => "1",
                "projectName" => "40authors manifesto",
                "stripeEmail" => "vlad.hontar@gmail.oc",
                "stripeToken" => "tok_CcMw8vmEEQal6Q",
                "stripeClientIP" => "195.49.164.134",
                "amount" => "10000"
            ]);
        } catch (StripeDonationsPluginException $e) {
            die($e->getMessage());
        }
    }
}