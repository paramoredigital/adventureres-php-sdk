<?php
/**
 * Copyright 2016 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace AdventureRes\Tests\Models\Input;

use AdventureRes\Models\Input\PaymentInputModel;

class PaymentInputModelTest extends \PHPUnit_Framework_TestCase
{
    private $attributes = [
      'ReservationId'   => 123,
      'CustomerId'      => 456,
      'PaymentMethodId' => 1,
      'Address'         => '555 Main Street',
      'Address2'        => '',
      'City'            => 'Nashville',
      'State'           => 'TN',
      'Zip'             => 37211,
      'HomePhone'       => '6155551234',
      'WorkPhone'       => '',
      'CellPhone'       => '',
      'Email'           => 'joe@adventureres.com',
      'Organization'    => '',
      'CreditCard'      => 4111111111111111,
      'ExpirationDate'  => '06/19',
      'CID'             => '001',
      'Amount'          => 200.00,
      'PromoCode'       => ''
    ];

    public function testValidationTypes()
    {
        $model = PaymentInputModel::populateModel($this->attributes);

        $this->assertTrue($model->isValid());
    }

    public function testDateFormatValidation()
    {
        $model = PaymentInputModel::populateModel($this->attributes);

        $this->assertTrue($model->isValid());

        $model->ExpirationDate = '06/30/2016';

        $this->assertFalse($model->isValid());
    }

    public function testEmailValidation()
    {
        $model = PaymentInputModel::populateModel($this->attributes);

        $this->assertTrue($model->isValid());

        $model->Email = 'joe@gmail';

        $this->assertFalse($model->isValid());
    }

    public function testCreditCardValidation()
    {
        $model = PaymentInputModel::populateModel($this->attributes);

        $this->assertTrue($model->isValid());

        $model->CreditCard = '4111 1111 1111 1111'; // shouldn't allow spaces

        $this->assertFalse($model->isValid());
    }
}
