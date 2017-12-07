<?php
/**
 * donations-free plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace endurant\stripedonation\services;

use craft\base\Component;

use endurant\stripedonation\records\StripeDonationSetting as StripeDonationSettingRecord;
use endurant\stripedonation\models\StripeDonationSetting;

/**
 * Donate Service
 *
 * All of your plugin’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    endurant
 * @package   Donationsfree
 * @since     1.0.0
 */
class DonationsSettingsService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * @param StripeDonationSetting $model
     * @return array|null
     * @throws \Exception
     * @throws \yii\db\StaleObjectException
     */
    public function update(StripeDonationSetting $model)
    {
        if ($model->validate()) {
            $record = new StripeDonationSettingRecord();
            $record->setAttributes($model->getAttributes(), false);

            if (!$record->update()) {
                return ['success' => false, 'errors' => $record->getErrors()];
            }

            return ['success' => true, 'settings' => $record];
        }

        return ['success' => false, 'errors' => $model->getErrors()];
    }
}
