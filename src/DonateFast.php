<?php

namespace infoservio\donatefast;

use infoservio\donatefast\services\CustomerService;
use infoservio\donatefast\components\httpClient\stripe\StripeHttpClient;
use infoservio\donatefast\components\logger\Logger;
use infoservio\donatefast\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\web\UrlManager;
use craft\events\PluginEvent;
use craft\events\RegisterUrlRulesEvent;
use craft\events\RegisterCpNavItemsEvent;
use craft\web\twig\variables\Cp;

use infoservio\donatefast\services\CardService;
use infoservio\donatefast\services\ChargeService;
use infoservio\donatefast\services\DonationService;
use infoservio\donatefast\services\DonationsSettingsService;
use infoservio\donatefast\services\LogService;
use infoservio\donatefast\services\PluginService;
use infoservio\donatefast\services\StripeService;
use yii\base\Event;

/**
 * Craft plugins are very much like little applications in and of themselves. We’ve made
 * it as simple as we can, but the training wheels are off. A little prior knowledge is
 * going to be required to write a plugin.
 *
 * For the purposes of the plugin docs, we’re going to assume that you know PHP and SQL,
 * as well as some semi-advanced concepts like object-oriented programming and PHP namespaces.
 *
 * https://craftcms.com/docs/plugins/introduction
 *
 * @author    Vlad Hontar
 * @package   Billionglobalserver
 * @since     1.0.0
 *
 * @property  CardService $card
 * @property  ChargeService $charge
 * @property  CustomerService $customer
 * @property  DonationService $donation
 * @property  DonationsSettingsService $donationSettings
 * @property  LogService $log
 * @property  PluginService $pluginService
 * @property  StripeService $stripe
 * @property  StripeHttpClient $stripeClient
 * @property  Logger $donationLogger
 * @property  Settings $settings
 * @method    Settings getSettings()
 */
class DonateFast extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * Static property that is an instance of this plugin class so that it can be accessed via
     * DonationsFree::$plugin
     *
     * @var DonateFast
     */
    public static $plugin;

    // Public Methods
    // =========================================================================

    /**
     * Set our $plugin static property to this class so that it can be accessed via
     * Donationsfree::$plugin
     *
     * Called after the plugin class is instantiated; do any one-time initialization
     * here such as hooks and events.
     *
     * If you have a '/vendor/autoload.php' file, it will be loaded for you automatically;
     * you do not need to load it in your init() method.
     *
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                    // We were just installed
                    $this->hasCpSection = true;
                    $this->hasCpSettings = true;
                }
            }
        );

        Event::on(Cp::class, Cp::EVENT_REGISTER_CP_NAV_ITEMS, function(RegisterCpNavItemsEvent $event) {
            if (\Craft::$app->user->identity->admin) {
//                $event->navItems['donations-free'] = [
//                    'label' => 'Donations Manager',
//                    'url' => 'donations-free/settings'
//                ];
            }
        });

        // Register our site routes
        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_SITE_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['donate-fast/invoice/view'] = 'donate-fast/invoice/view';
                $event->rules['donate-fast/donate'] = 'donate-fast/donation/donate';
                $event->rules['donate-fast/test'] = 'donate-fast/test/index';
            }
        );

        // Register our CP routes
        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['donate-fast'] = 'donate-fast/invoice/index';
                $event->rules['donate-fast/settings'] = 'donate-fast/settings/settings';
                $event->rules['donate-fast/donation-form'] = 'donate-fast/settings/donation-form';
                $event->rules['donate-fast/invoice'] = 'donate-fast/invoice/index';
                $event->rules['donate-fast/invoice/view'] = 'donate-fast/invoice/view';
                $event->rules['donate-fast/invoice/send'] = 'donate-fast/invoice/send';
            }
        );

        Craft::info(
            Craft::t(
                'donate-fast',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

//    public function getCpNavItem()
//    {
//        $item = parent::getCpNavItem();
//        $item['subnav'] = [
//            'settings' => ['label' => 'Settings Manager', 'url' => 'donations-free/settings'],
//            'fields' => ['label' => 'Fields Manager', 'url' => 'donations-free/fields'],
//            'steps' => ['label' => 'Steps Manager', 'url' => 'donations-free/steps'],
//        ];
//        return $item;
//    }

    // Protected Methods
    // =========================================================================

    /**
     * Creates and returns the model used to store the plugin’s settings.
     *
     * @return \craft\base\Model|null
     */
    protected function createSettingsModel(): Settings
    {
        return new Settings();
    }

    /**
     * Returns the rendered settings HTML, which will be inserted into the content
     * block on the settings page.
     *
     * @return string The rendered settings HTML
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'donate-fast/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }
}