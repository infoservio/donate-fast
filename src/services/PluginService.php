<?php
/**
 * donations-free plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace infoservio\stripedonation\services;

use craft\base\Component;
use infoservio\stripedonation\records\StripeDonationSetting;

/**
 * Plugin Service
 *
 * @author    infoservio
 * @package   Donationsfree
 * @since     1.0.0
 */
class PluginService extends Component
{
    public function update(array $post)
    {
        $settings = StripeDonationSetting::find()->all();

        foreach ($settings as $setting) {

            foreach ($post as $k => $v) {
                if ($setting->name == $k) {
                    $setting->value = $v;
                    $setting->save();
                }
            }
        }
    }
}
