<?php

namespace AdventureRes\Tests\Models;

use AdventureRes\Models\Input\ServiceDisplayInputModel;

class ServiceDisplayInputModelTest extends \PHPUnit_Framework_TestCase
{
    public function testServiceIdIsRequired()
    {
        $model = new ServiceDisplayInputModel();

        $this->assertFalse($model->isValid());

        $model->ServiceId = 123;

        $this->assertTrue($model->isValid());
    }
}
