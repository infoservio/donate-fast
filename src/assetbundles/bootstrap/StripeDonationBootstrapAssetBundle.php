<?php
/**
 * donations-free plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace endurant\stripedonation\assetbundles\bootstrap;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * StripeDonationBootstrapAssetBundle AssetBundle
 *
 * @author    endurant
 * @package   Donationsfree
 * @since     1.0.0
 */
class StripeDonationBootstrapAssetBundle extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * Initializes the bundle.
     */
    public function init()
    {
        // define the path that your publishable resources live
        $this->sourcePath = '@endurant/stripedonation/assetbundles/bootstrap/dist';

        $this->js = [
            'js/index.js'
        ];

        $this->css = [
            'css/style.css',
            'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css',
        ];

        $this->depends = [
            'yii\web\JqueryAsset',
        ];

        parent::init();
    }
}
