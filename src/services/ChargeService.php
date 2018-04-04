<?php

namespace infoservio\donatefast\services;

use craft\base\Component;

use infoservio\donatefast\errors\DbDonationsPluginException;
use infoservio\donatefast\records\Charge as TransactionRecord;
use infoservio\donatefast\models\Charge as ChargeModel;
use infoservio\donatefast\models\Log as LogModel;

class ChargeService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * @param ChargeModel $model
     * @return TransactionRecord|null
     * @throws DbDonationsPluginException
     */
    public function save(ChargeModel $model)
    {
        if ($model->validate()) {
            $record = new TransactionRecord();
            $record->setAttributes($model->getAttributes(), false);

            if (!$record->save()) {

                throw new DbDonationsPluginException(
                    $record->errors,
                    json_encode($record->toArray()),
                    __METHOD__,
                    LogModel::CHARGE_LOGS
                );
            }

            return $record;
        }

        return null;
    }
}
