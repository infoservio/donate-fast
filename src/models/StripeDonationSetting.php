<?php

namespace infoservio\donatefast\models;

use craft\base\Model;
use infoservio\donatefast\records\StripeDonationSetting as StripeDonationSettingRecord;

/**
 * StripeDonationSetting Model
 *
 * @author    infoservio
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
