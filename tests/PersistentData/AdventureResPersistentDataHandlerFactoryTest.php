<?php
/**
 * Copyright 2016 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace AdventureRes\Tests;

use AdventureRes\PersistentData\AdventureResPersistentDataHandlerFactory;

class AdventureResPersistentDataHandlerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AdventureResPersistentDataHandlerFactory
     */
    private $factory;

    public function setUp()
    {
        $this->factory = new AdventureResPersistentDataHandlerFactory();
    }

    public function testCanCreateClassInstanceFromFullName()
    {
        $name = '\AdventureRes\PersistentData\PhpSessionPersistentDataHandler';
        $instance = $this->factory->createDataHandler($name);

        $this->assertInstanceOf('\AdventureRes\PersistentData\AdventureResPersistentDataInterface', $instance);
        $this->assertInstanceOf('\AdventureRes\PersistentData\PhpSessionPersistentDataHandler', $instance);
    }

    /**
     * @expectedException \AdventureRes\Exceptions\AdventureResSDKException
     */
    public function testNonExistentClassThrowsException()
    {
        $name = 'FooBar';

        $this->factory->createDataHandler($name);
    }
}
