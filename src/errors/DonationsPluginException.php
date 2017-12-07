<?php

namespace endurant\stripedonation\errors;
use endurant\stripedonation\services\LogService;
use endurant\stripedonation\StripeDonation;

class DonationsPluginException extends \Exception
{
    protected $message;
    protected $method;
    protected $errors;
    protected $culprit;
    /** @var LogService $_logService **/
    private $_logService;

    public function __construct(array $errors, string $message, string $method, string $category)
    {
        parent::__construct();
        $this->errors = $errors;
        $this->message = $message;
        $this->method = $method;

        $this->_logService = StripeDonation::$PLUGIN->log;
        $this->log($category);
    }
    
    public function getErrors() 
    {
        return json_encode($this->errors);
    }

    protected function log(string $category)
    {
        $this->_logService->setCategory($category);
        $this->_logService->log($this->errors, $this->message, $this->method, $this->culprit);
    }
}