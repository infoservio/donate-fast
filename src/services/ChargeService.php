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

use infoservio\stripedonation\errors\DbDonationsPluginException;
use infoservio\stripedonation\records\Charge as TransactionRecord;
use infoservio\stripedonation\models\Charge;
use infoservio\stripedonation\models\Log;

/**
 * Charge Service
 *
 * @author    infoservio
 * @package   Donationsfree
 * @since     1.0.0
 */
class ChargeService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * @param Charge $model
     * @return TransactionRecord|null
     * @throws DbDonationsPluginException
     */
    public function save(Charge $model)
    {
        if ($model->validate()) {
            $record = new TransactionRecord();
            $record->setAttributes($model->getAttributes(), false);

            if (!$record->save()) {

                throw new DbDonationsPluginException(
                    $record->errors,
                    json_encode($record->toArray()),
                    __METHOD__,
                    Log::CHARGE_LOGS
                );
            }

            return $record;
        }

        return null;
    }
}
