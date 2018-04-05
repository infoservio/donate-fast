<?php

namespace infoservio\donatefast\services;

use craft\base\Component;

use infoservio\donatefast\errors\DbDonationsPluginException;
use infoservio\donatefast\records\Card as CardRecord;
use infoservio\donatefast\models\Card as CardModel;
use infoservio\donatefast\models\Log as LogModel;

class CardService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * @param CardModel $model
     * @return CardRecord
     * @throws DbDonationsPluginException
     */
    public function save(CardModel $model)
    {
        if ($model->validate()) {
            $record = new CardRecord();
            $record->setAttributes($model->getAttributes(), false);

            if (!$record->save()) {

                throw new DbDonationsPluginException(
                    $record->errors,
                    json_encode($record->toArray()),
                    __METHOD__,
                    LogModel::CARD_LOGS
                );
            }

            return $record;
        }

        return null;
    }
}
