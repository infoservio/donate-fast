<?php

namespace infoservio\donatefast\errors;

use infoservio\donatefast\models\Log;

class StripeDonationsPluginException extends DonationsPluginException
{
    protected $culprit = Log::STRIPE_CULPRIT;
    
    public function __construct(array $errors, string $message, string $method, string $category) {
        parent::__construct($errors, $message, $method, $category);
    }
}