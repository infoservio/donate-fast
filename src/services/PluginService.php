<?php

namespace infoservio\donatefast\services;

use craft\base\Component;
use infoservio\donatefast\records\StripeDonationSetting as StripeDonationSettingRecord;

class PluginService extends Component
{
    public function update(array $post)
    {
        $settings = StripeDonationSettingRecord::find()->all();

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
