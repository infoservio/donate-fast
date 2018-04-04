<?php

namespace infoservio\donatefast\services;

use infoservio\donatefast\DonateFast;
use craft\base\Component;

class LogService extends Component
{
    private $_donationLogger;

    public function __construct()
    {
        parent::__construct();
        $this->_donationLogger = DonateFast::$plugin->donationLogger;
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
