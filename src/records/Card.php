<?php
namespace infoservio\donatefast\records;

use craft\db\ActiveRecord;

/**
 * Card Record
 *
 * @property integer $id
 * @property string $tokenId
 * @property integer $customerId
 * @property string $last4
 * @property string $cardType
 * @property integer $expMonth
 * @property integer $expYear
 * @property string $fingerprint
 * @property string $customerLocation
 * @property string $dateCreated
 * @property string $dateUpdated
 * @property string $uid
 */
class Card extends ActiveRecord
{
    // Public Static Methods
    // =========================================================================

    /**
     * @return string the table name
     */
    public static function tableName()
    {
        return '{{donate_fast_card}}';
    }

    public function getCustomer()
    {
        return Customer::find()->where(['id' => $this->customerId])->one();
    }
}
