<?php
/**
 * donations-free plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace infoservio\donatefast\services;

use craft\base\Component;

use infoservio\donatefast\errors\DbDonationsPluginException;
use infoservio\donatefast\records\Card as CardRecord;
use infoservio\donatefast\models\Card;
use infoservio\donatefast\models\Log;

/**
 * Donate Service
 *
 * @author    infoservio
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
