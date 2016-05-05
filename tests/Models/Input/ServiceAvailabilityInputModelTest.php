<?php

namespace AdventureRes\Tests\Models;

use AdventureRes\Models\Input\ServiceAvailabilityInputModel;

class ServiceAvailabilityInputModelTest extends \PHPUnit_Framework_TestCase
{
    public function testServiceIdIsRequired()
    {
        $model = ServiceAvailabilityInputModel::populateModel([
          'LocationId' => 10,
          'AdultQty'   => 2,
          'YouthQty'   => 0,
          'Units'      => 0,
          'StartDate'  => '06/01/2016',
          'Display'    => 'ITEM'
        ]);

        $valid = $model->isValid();

        $this->assertFalse($valid);
        $this->assertArrayHasKey('ServiceId', $model->getErrors());
    }

    public function testLocationIdIsRequired()
    {
        $model = ServiceAvailabilityInputModel::populateModel([
          'ServiceId' => 123,
          'AdultQty'  => 2,
          'YouthQty'  => 0,
          'Units'     => 0,
          'StartDate' => '06/01/2016',
          'Display'   => 'ITEM'
        ]);

        $valid = $model->isValid();

        $this->assertFalse($valid);
        $this->assertArrayHasKey('LocationId', $model->getErrors());
    }

    public function testStartDateIsRequired()
    {
        $model = ServiceAvailabilityInputModel::populateModel([
          'ServiceId'  => 123,
          'LocationId' => 10,
          'AdultQty'   => 2,
          'YouthQty'   => 0,
          'Units'      => 0,
          'Display'    => 'ITEM'
        ]);

        $valid = $model->isValid();

        $this->assertFalse($valid);
        $this->assertArrayHasKey('StartDate', $model->getErrors());
    }

    public function testStartDateValidatesFormat()
    {
        $model = ServiceAvailabilityInputModel::populateModel([
          'ServiceId'  => 123,
          'LocationId' => 10,
          'AdultQty'   => 2,
          'YouthQty'   => 0,
          'Units'      => 0,
          'StartDate'  => 'May 29, 2016',
          'Display'    => 'ITEM'
        ]);

        $valid = $model->isValid();

        $this->assertFalse($valid);
        $this->assertArrayHasKey('StartDate', $model->getErrors());
    }

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
