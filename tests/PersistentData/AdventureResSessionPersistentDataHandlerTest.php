<?php

use AdventureRes\PersistentData\AdventureResSessionPersistentDataHandler;

class AdventureResSessionPersistentDataHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \AdventureRes\Exceptions\AdventureResSDKException
     */
    public function testInactiveSessionWillThrowException()
    {
        $handler = new AdventureResSessionPersistentDataHandler();
    }

    public function testSet()
    {
        $handler = new AdventureResSessionPersistentDataHandler($shouldCheckSessionStatus = false);

        $handler->set('scud', 'stud');
        $this->assertEquals('stud', $_SESSION['ADVRES_scud']);
    }

    public function testGet()
    {
        $_SESSION['ADVRES_foo'] = 'bar';
        $handler                = new AdventureResSessionPersistentDataHandler($shouldCheckSessionStatus = false);

        $this->assertEquals('bar', $handler->get('foo'));
    }

    public function testGettingNonexistentValueReturnsNull()
    {
        $handler = new AdventureResSessionPersistentDataHandler($shouldCheckSessionStatus = false);

        $this->assertNull($handler->get('i_do_not_exist'));
    }
}
