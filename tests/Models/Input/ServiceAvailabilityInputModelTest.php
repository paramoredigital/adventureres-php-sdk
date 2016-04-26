<?php

namespace AdventureRes\Tests\Models;

use AdventureRes\Models\Input\ServiceAvailabilityInputModel;

class ServiceAvailabilityInputModelTest extends \PHPUnit_Framework_TestCase
{
    public function testAdultQtyDefaultsToZero()
    {
        $model = new ServiceAvailabilityInputModel();

        $this->assertSame(0, $model->getAttribute('AdultQty'));
    }

    public function testYouthQtyDefaultsToZero()
    {
        $model = new ServiceAvailabilityInputModel();

        $this->assertSame(0, $model->getAttribute('YouthQty'));
    }

    public function testUnitsDefaultsToZero()
    {
        $model = new ServiceAvailabilityInputModel();

        $this->assertSame(0, $model->getAttribute('Units'));
    }

    public function testCanOverrideDefaultValue()
    {
        $model = ServiceAvailabilityInputModel::populateModel(['AdultQty' => 2]);

        $this->assertSame(2, $model->getAttribute('AdultQty'));
    }
}
