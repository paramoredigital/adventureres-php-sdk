<?php

/**
 * Copyright 2016 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace AdventureRes;

/**
 * Class AdventureResApp
 *
 * @package AdventureRes
 */
class AdventureResApp
{
    /**
     * @var string
     */
    protected $baseDomain;
    /**
     * @var string
     */
    protected $apiKey;
    /**
     * @var string
     */
    protected $username;
    /**
     * @var string
     */
    protected $password;
    /**
     * @var int The location ID set from configs.
     */
    protected $location;

    /**
     * AdventureResApp constructor.
     *
     * @param string $baseDomain
     * @param string $apiKey
     * @param string $username
     * @param string $password
     * @param int $location
     */
    public function __construct(
      $baseDomain = null,
      $apiKey = null,
      $username = null,
      $password = null,
      $location = null
    )
    {
        $this->setBaseDomain($baseDomain);
        $this->setApiKey($apiKey);
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setLocation($location);
    }

    /**
     * Gets the configured base domain.
     *
*@return string
     */
    public function getBaseDomain()
    {
        return $this->baseDomain;
    }

    /**
     * Sets the base domain.
     *
*@param string $baseDomain
     */
    public function setBaseDomain($baseDomain)
    {
        $this->baseDomain = $baseDomain;
    }

    /**
     * Gets the configured API key.
     *
*@return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Sets the API key.
     *
*@param string $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Gets the configured username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Sets the username.
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Gets the configured Password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Sets the password.
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Gets the configured Location.
     *
     * @return int
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Sets the location.
     *
     * @param int $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

}

/* End of AdventureResApp.php */