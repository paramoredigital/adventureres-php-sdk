<?php

/**
 * Copyright 2016 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace AdventureRes\PersistentData;

use AdventureRes\Exceptions\AdventureResSDKException;

/**
 * Class AdventureResSessionPersistentDataHandler
 *
 * @package AdventureRes
 */
class AdventureResSessionPersistentDataHandler
{
    /**
     * @var string Prefix to use for session variables.
     */
    protected $sessionPrefix = 'ADVRES_';

    /**
     * @param boolean $shouldCheckSessionStatus
     * @throws AdventureResSDKException
     */
    public function __construct($shouldCheckSessionStatus = true)
    {
        if ($shouldCheckSessionStatus && session_status() !== PHP_SESSION_ACTIVE) {
            throw new AdventureResSDKException(
              'Sessions are not active. Activate sessions by placing session_start() is at the top of your script.'
            );
        }
    }

    /**
     * Gets a variable from the PHP Session.
     *
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return (isset($_SESSION[$this->sessionPrefix . $key]))
          ? $_SESSION[$this->sessionPrefix . $key]
          : null;
    }

    /**
     * Sets a variable to the PHP Session.
     *
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value)
    {
        $_SESSION[$this->sessionPrefix . $key] = $value;
    }
}

/* End of AdventureResSessionPersistentDataHandler.php */