<?php
/**
 * Copyright 2016 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace AdventureRes;

use AdventureRes\Services\AdventureResReservationService;
use AdventureRes\Services\AdventureResServiceService;

/**
 * Class AdventureRes
 *
 * @package AdventureRes
 */
class AdventureRes extends AbstractAdventureResBase
{
    /**
     * The current version of the SDK
     */
    const VERSION = '1.0';
    /**
     * The API version that this SDK is compatible with.
     */
    const API_VERSION = '5.0.4';

    /**
     * @var \AdventureRes\AdventureResApp
     */
    private $app;

    /**
     * AdventureRes constructor.
     *
     * @param $baseDomain
     * @param $apiKey
     * @param $username
     * @param $password
     * @param $location
     */
    public function __construct($baseDomain, $apiKey, $username, $password, $location)
    {
        $this->app = new AdventureResApp($baseDomain, $apiKey, $username, $password, $location);
    }

    /**
     * A shortcut method to get an instance of the Service service
     *
*@return AdventureResServiceService
     */
    public function service()
    {
        return new AdventureResServiceService($this->app);
    }

    /**
     * A shortcut method to get an instance of the Reservation service
     *
*@return AdventureResReservationService
     */
    public function reservation()
    {
        return new AdventureResReservationService($this->app);
    }

    /**
     * Gets the configured app.
     *
*@return AdventureResApp
     */
    public function getApp()
    {
        return $this->app;
    }
}

/* End of AdventureRes.php */