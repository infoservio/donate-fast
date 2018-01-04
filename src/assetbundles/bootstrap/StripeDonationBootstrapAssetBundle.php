<?php

namespace infoservio\donatefast\assetbundles\bootstrap;

use craft\web\AssetBundle;

/**
 * StripeDonationBootstrapAssetBundle AssetBundle
 *
 * @author    infoservio
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
        $this->sourcePath = '@infoservio/donatefast/assetbundles/bootstrap/dist';

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
