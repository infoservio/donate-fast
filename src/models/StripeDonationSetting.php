<?php
/**
 * donations-free plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace endurant\stripedonation\models;

use craft\base\Model;
use endurant\stripedonation\records\StripeDonationSetting as StripeDonationSettingRecord;

/**
 * StripeDonationSetting Model
 *
 * @author    endurant
 * @package   Donationsfree
 * @since     1.0.0
 */
class StripeDonationSetting extends Model
{
    // Public Properties
    // =========================================================================

    public $id;
    public $name;
    public $value;

    public static function getSettingsArr()
    {
        $settings = StripeDonationSettingRecord::find()->all();
        $settingsArr = [];

        foreach ($settings as $value) {
            $settingsArr[$value->name] = $value->value;
        }

        return $settingsArr;
    }

    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes.
     * @return array
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'value'], 'string'],
            [['name', 'value'], 'required']
        ];
    }
}
