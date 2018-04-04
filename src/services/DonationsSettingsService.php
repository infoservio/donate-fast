<?php

namespace infoservio\donatefast\services;

use craft\base\Component;

use infoservio\donatefast\records\StripeDonationSetting as StripeDonationSettingRecord;
use infoservio\donatefast\models\StripeDonationSetting as StripeDonationSettingModel;

class DonationsSettingsService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * @param StripeDonationSettingModel $model
     * @return array|null
     * @throws \Throwable
     */
    public function update(StripeDonationSettingModel $model)
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
