<?php

namespace infoservio\donatefast\records;

use craft\db\ActiveRecord;
use infoservio\fastsendnote\records\Mail;

/**
 * Charge Record
 *
 * @property integer $id
 * @property string $chargeId
 * @property integer $cardId
 * @property float $amount
 * @property float $amountRefunded
 * @property string $balanceTransaction
 * @property string $currency
 * @property integer $projectId
 * @property string $projectName
 * @property string $clientIp
 * @property string $fraudDetails
 * @property string $failureCode
 * @property string $failureMessage
 * @property integer $created
 * @property string $dateCreated
 * @property string $dateUpdated
 * @property string $uid
 */
class Charge extends ActiveRecord
{
    // Public Static Methods
    // =========================================================================


    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{donate_fast_charge}}';
    }

    public static function getColumns()
    {
        return ['ID', 'Charge ID', 'Email', 'Project', 'Amount', 'Created', 'Email Status'];
    }

    public static function getAll()
    {
        return self::find()->orderBy('id DESC')->all();
    }

    public static function getById(int $id, bool $returnActiveRecordObj = false)
    {
        $obj = self::find()->where(['id' => $id])->one();
        if (!$obj) {
            return false;
        }

        if ($returnActiveRecordObj) {
            return $obj;
        }

        return new self($obj);
    }

    /**
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getCard()
    {
        return Card::find()->where(['id' => $this->cardId])->one();
    }

    public function getMail()
    {
        return Mail::find()->where(['customId' => $this->chargeId])->one();
    }
}
