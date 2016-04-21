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

    public function __construct($baseDomain = null, $apiKey = null, $username = null, $password = null)
    {
        $this->setBaseDomain($baseDomain);
        $this->setApiKey($apiKey);
        $this->setUsername($username);
        $this->setPassword($password);
    }

    /**
     * @return string
     */
    public function getBaseDomain()
    {
        return $this->baseDomain;
    }

    /**
     * @param string $baseDomain
     */
    public function setBaseDomain($baseDomain)
    {
        $this->baseDomain = $baseDomain;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
}

/* End of AdventureResApp.php */