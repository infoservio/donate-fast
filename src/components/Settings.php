<?php
namespace endurant\stripedonation\components;

class Settings
{
    /**
     * This method is used to create process id
     * @return int
     */
    public static function createProcessID()
    {
        // TODO You can create something more beautiful
        return time();
    }
}