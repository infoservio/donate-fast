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

use infoservio\donatefast\DonateFast;
use craft\base\Component;

/**
 * Log Service
 *
 * @author    infoservio
 * @package   Donationsfree
 * @since     1.0.0
 */
class LogService extends Component
{
    private $_donationLogger;

    public function __construct()
    {
        parent::__construct();
        $this->_donationLogger = DonateFast::$PLUGIN->donationLogger;
    }

    // Public Methods
    // =========================================================================

    /**
     * @param string $category
     */
    public function setCategory(string $category)
    {
        $this->_donationLogger->setCategory($category);
    }

    /**
     * @param array $errors
     * @param string $message
     * @param string $method
     * @param array $culprit
     * @return mixed
     */
    public function log(array $errors, string $message, string $method, array $culprit)
    {
        return $this->_donationLogger->record($errors, $message, $method, $culprit);
    }
}
