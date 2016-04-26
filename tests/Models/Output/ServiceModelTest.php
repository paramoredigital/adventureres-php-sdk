<?php

namespace AdventureRes\Tests\Models;

use AdventureRes\Models\Output\ServiceModel;

class ServiceModelTest extends \PHPUnit_Framework_TestCase
{
    public function testServiceIdIsRequired()
    {
        $data = [
          'Description' => 'Foo'
        ];

        $model = ServiceModel::populateModel($data);

        $this->assertFalse($model->isValid());

        $model->ServiceId = 123;

        $this->assertTrue($model->isValid());
    }

    public function testDescriptionIsRequired()
    {
        $data = [
          'ServiceId' => 123
        ];

        $model = ServiceModel::populateModel($data);

        $this->assertFalse($model->isValid());

        $model->Description = 'Foo';

        $this->assertTrue($model->isValid());
    }
}
