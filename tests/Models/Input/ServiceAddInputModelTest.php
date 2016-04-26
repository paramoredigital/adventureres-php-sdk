<?php

namespace AdventureRes\Tests\Models;

use AdventureRes\Models\Input\ServiceAddInputModel;

class ServiceAddInputModelTest extends \PHPUnit_Framework_TestCase
{
    public function testReservationIdDefaultsToZero()
    {
        $model = new ServiceAddInputModel();

        $this->assertSame(0, $model->getAttribute('ReservationId'));
    }

    public function testCustomerIdDefaultsToZero()
    {
        $model = new ServiceAddInputModel();

        $this->assertSame(0, $model->getAttribute('CustomerId'));
    }

    public function testAdultQtyDefaultsToZero()
    {
        $model = new ServiceAddInputModel();

        $this->assertSame(0, $model->getAttribute('AdultQty'));
    }

    public function testYouthQtyDefaultsToZero()
    {
        $model = new ServiceAddInputModel();

        $this->assertSame(0, $model->getAttribute('YouthQty'));
    }

    public function testUnitsDefaultsToZero()
    {
        $model = new ServiceAddInputModel();

        $this->assertSame(0, $model->getAttribute('Units'));
    }

}
