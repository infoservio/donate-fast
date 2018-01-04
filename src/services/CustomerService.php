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
use infoservio\donatefast\records\Customer as CustomerRecord;
use infoservio\donatefast\models\Customer;
use infoservio\donatefast\models\Log;

/**
 * Donate Service
 *
 * All of your plugin’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    infoservio
 * @package   Donationsfree
 * @since     1.0.0
 */
class CustomerService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * @param Customer $model
     * @return CustomerRecord|null
     * @throws DbDonationsPluginException
     */
    public function save(Customer $model)
    {
        if ($model->validate()) {
            $record = new CustomerRecord();
            $record->setAttributes($model->getAttributes(), false);

            if (!$record->save()) {

                throw new DbDonationsPluginException(
                    $record->errors,
                    json_encode($record->toArray()),
                    __METHOD__,
                    Log::CUSTOMER_LOGS
                );
            }

            return $record;
        }

        return null;
    }
}
