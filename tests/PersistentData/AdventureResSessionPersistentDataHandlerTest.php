<?php

use AdventureRes\PersistentData\PhpSessionPersistentDataHandler;

class AdventureResSessionPersistentDataHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \AdventureRes\Exceptions\AdventureResSDKException
     */
    public function testInactiveSessionWillThrowException()
    {
        $handler = new PhpSessionPersistentDataHandler($shouldCheckSessionStatus = true);
    }

    public function testSet()
    {
        $handler = new PhpSessionPersistentDataHandler($shouldCheckSessionStatus = false);

        $handler->set('scud', 'stud');
        $this->assertEquals('stud', $_SESSION['ADVRES_scud']);
    }

    public function testGet()
    {
        $_SESSION['ADVRES_foo'] = 'bar';
        $handler                = new PhpSessionPersistentDataHandler($shouldCheckSessionStatus = false);

        $this->assertEquals('bar', $handler->get('foo'));
    }

    public function testDelete()
    {
        $_SESSION['ADVRES_foo'] = 'bar';
        $handler                = new PhpSessionPersistentDataHandler($shouldCheckSessionStatus = false);

        $handler->delete('foo');

        $this->assertNull($handler->get('foo'));
    }

    public function testGettingNonexistentValueReturnsNull()
    {
        $handler = new PhpSessionPersistentDataHandler($shouldCheckSessionStatus = false);

        $this->assertNull($handler->get('i_do_not_exist'));
    }
}
