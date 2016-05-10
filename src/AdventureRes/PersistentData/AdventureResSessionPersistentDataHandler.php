<?php

/**
 * Copyright 2016 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace AdventureRes\PersistentData;

use AdventureRes\AbstractAdventureResBase;
use AdventureRes\Exceptions\AdventureResSDKException;

/**
 * Class AdventureResSessionPersistentDataHandler
 *
 * @package AdventureRes
 */
class AdventureResSessionPersistentDataHandler extends AbstractAdventureResBase
{
    /**
     * @var string Prefix to use for session variables.
     */
    protected $sessionPrefix = 'ADVRES_';

    /**
     * @param boolean $shouldCheckSessionStatus
     * @throws AdventureResSDKException
     */
    public function __construct($shouldCheckSessionStatus = false)
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
     * @param mixed $defaultValue If the key doesn't exist in the session, you can provide an optional default value.
     * @return mixed
     */
    public function get($key, $defaultValue = null)
    {
        return (isset($_SESSION[$this->sessionPrefix . $key]))
          ? $_SESSION[$this->sessionPrefix . $key]
          : $defaultValue;
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

    /**
     * Deletes a variable from the PHP Session.
     *
     * @param $key
     */
    public function delete($key)
    {
        unset($_SESSION[$this->sessionPrefix . $key]);
    }
}

/* End of AdventureResSessionPersistentDataHandler.php */