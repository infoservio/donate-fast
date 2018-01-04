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
 * Address Record
 *
 * @property integer $id
 * @property integer $pid
 * @property integer $culprit
 * @property string $category
 * @property string $method
 * @property string $errors
 * @property string $message
 * @property string $dateCreated
 * @property string $dateUpdated
 * @property string $uid
 */
class Log extends ActiveRecord
{
    // Public Static Methods
    // =========================================================================

    /**
     * @return string the table name
     */
    public static function tableName()
    {
        return '{{stripe_donation_log}}';
    }
}
