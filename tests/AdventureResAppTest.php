<?php
/**
 * Copyright 2016 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace AdventureRes\Tests;

use AdventureRes\AdventureResApp;

class AdventureResAppTest extends \PHPUnit_Framework_TestCase
{
    public function testCanGenerateDataHandler()
    {
        $app = new AdventureResApp();

        $this->assertInstanceOf('\AdventureRes\PersistentData\AdventureResPersistentDataInterface', $app->getDataHandler());
    }

    public function testCanSetDataHandlerName()
    {
        $app = new AdventureResApp();

        $app->setDataHandler('\AdventureRes\PersistentData\PhpSessionPersistentDataHandler');

        $this->assertInstanceOf('\AdventureRes\PersistentData\PhpSessionPersistentDataHandler', $app->getDataHandler());
    }

    public function testCanSetDataHandlerByName()
    {
        $app = new AdventureResApp(null, null, null, null, null, '\AdventureRes\PersistentData\PhpSessionPersistentDataHandler');

        $this->assertInstanceOf('\AdventureRes\PersistentData\PhpSessionPersistentDataHandler', $app->getDataHandler());
    }
}
