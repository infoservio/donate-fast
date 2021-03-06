<?php
/**
 * donations-free plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace infoservio\donatefast\records;

use craft\db\ActiveRecord;

/**
 * Customer Record
 *
 * @property integer $id
 * @property string $customerId
 * @property string $email
 * @property string $phone
 * @property string $description
 * @property string $dateCreated
 * @property string $dateUpdated
 * @property string $uid
 */
class Customer extends ActiveRecord
{
    // Public Static Methods
    // =========================================================================

    /**
     * @return string the table name
     */
    public static function tableName()
    {
        return '{{donate_fast_customer}}';
    }
}
