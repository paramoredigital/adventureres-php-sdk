<?php
/**
 * Copyright 2016 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace AdventureRes\Tests;

use AdventureRes\AdventureRes;

class AdventureResTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructorCreatesAppInstance()
    {
        $advRes = $this->instantiateClass();

        $this->assertInstanceOf('\AdventureRes\AdventureResApp', $advRes->getApp());
    }

    public function testCanGetServiceInstance()
    {
        $advRes = $this->instantiateClass();

        $this->assertInstanceOf('\AdventureRes\Services\AdventureResServiceService', $advRes->service());
    }

    public function testCanGetReservationInstance()
    {
        $advRes = $this->instantiateClass();

        $this->assertInstanceOf('\AdventureRes\Services\AdventureResReservationService', $advRes->reservation());
    }

    protected function instantiateClass()
    {
        return new AdventureRes('foo.com', 'theApiKey', 'bar', 'baz', 10);
    }
}
