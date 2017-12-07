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

use endurant\stripedonation\errors\DbDonationsPluginException;
use endurant\stripedonation\records\Card as CardRecord;
use endurant\stripedonation\models\Card;
use endurant\stripedonation\models\Log;

/**
 * Donate Service
 *
 * @author    endurant
 * @package   Donationsfree
 * @since     1.0.0
 */
class CardService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * @param Card $model
     * @return CardRecord|null
     * @throws DbDonationsPluginException
     */
    public function save(Card $model)
    {
        if ($model->validate()) {
            $record = new CardRecord();
            $record->setAttributes($model->getAttributes(), false);

            if (!$record->save()) {

                throw new DbDonationsPluginException(
                    $record->errors,
                    json_encode($record->toArray()),
                    __METHOD__,
                    Log::CARD_LOGS
                );
            }

            return $record;
        }

        return null;
    }
}
