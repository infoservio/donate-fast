<?php

namespace infoservio\donatefast\services;

use craft\base\Component;

use infoservio\donatefast\errors\DbDonationsPluginException;
use infoservio\donatefast\records\Customer as CustomerRecord;
use infoservio\donatefast\models\Customer as CustomerModel;
use infoservio\donatefast\models\Log as LogModel;

class CustomerService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * @param CustomerModel $model
     * @return CustomerRecord|null
     * @throws DbDonationsPluginException
     */
    public function save(CustomerModel $model)
    {
        if ($model->validate()) {
            $record = new CustomerRecord();
            $record->setAttributes($model->getAttributes(), false);

            if (!$record->save()) {

                throw new DbDonationsPluginException(
                    $record->errors,
                    json_encode($record->toArray()),
                    __METHOD__,
                    LogModel::CUSTOMER_LOGS
                );
            }

            return $record;
        }

        return null;
    }
}
