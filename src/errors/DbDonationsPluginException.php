<?php

namespace infoservio\stripedonation\errors;

use infoservio\stripedonation\models\Log;


class DbDonationsPluginException extends DonationsPluginException
{
    protected $culprit = Log::DB_CULPRIT;
    
    public function __construct(array $errors, string $message, string $method, string $category) {
        parent::__construct($errors, $message, $method, $category);
    }
}