<?php

namespace infoservio\donatefast\assetbundles\settings;

use craft\web\AssetBundle;

/**
 * DonationsfreeAsset AssetBundle
 *
 * AssetBundle represents a collection of asset files, such as CSS, JS, images.
 *
 * Each asset bundle has a unique name that globally identifies it among all asset bundles used in an application.
 * The name is the [fully qualified class name](http://php.net/manual/en/language.namespaces.rules.php)
 * of the class representing it.
 *
 * An asset bundle can depend on other asset bundles. When registering an asset bundle
 * with a view, all its dependent asset bundles will be automatically registered.
 *
 * http://www.yiiframework.com/doc-2.0/guide-structure-assets.html
 *
 * @author    infoservio
 * @package   Donationsfree
 * @since     1.0.0
 */
class StripeDonationSettingsAssetBundle extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * Initializes the bundle.
     */
    public function init()
    {
        // define the path that your publishable resources live
        $this->sourcePath = '@infoservio/donatefast/assetbundles/settings/dist/';

        // define the relative path to CSS/JS files that should be registered with the page
        // when this asset bundle is registered
        $this->js = [
            'js/index.js',
            'js/jscolor.js',
        ];

        $this->css = [
            'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css',
            'css/style.css'
        ];

        $this->depends = [
            'yii\web\JqueryAsset',
        ];

        $this->publishOptions = ['forceCopy' => true];

        parent::init();
    }
}
