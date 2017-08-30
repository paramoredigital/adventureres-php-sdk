<?php
/**
 * Copyright 2016 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace AdventureRes\Models\Input;

use AdventureRes\Models\AbstractAdventureResModel;
use Respect\Validation\Validator;

/**
 * Class ReservationPaymentAddInputModel
 *
 * @package AdventureRes\Models\Input
 * @property int $ReservationId
 * @property int $CustomerId
 * @property string $FirstName
 * @property string $LastName
 * @property string $Comments
 * @property int $PaymentMethodId
 * @property string $Address
 * @property string $Address2 Optional
 * @property string $City
 * @property string $State
 * @property string $Zip
 * @property string $HomePhone
 * @property string $WorkPhone Optional
 * @property string $CellPhone Optional
 * @property string $Email
 * @property string $Organization Optional
 * @property string $CreditCard
 * @property string $ExpirationDate
 * @property string $CID
 * @property float $Amount
 * @property string $PromoCode Optional
 * @property int $LocationId
 */
class ReservationPaymentAddInputModel extends AbstractAdventureResModel
{
    /**
     * {@inheritdoc}
     */
    protected function defineAttributes()
    {
        return [
            'ReservationId'   => Validator::intType(),
            'CustomerId'      => Validator::intType(),
            'FirstName'       => Validator::stringType(),
            'LastName'        => Validator::stringType(),
            'Comments'        => Validator::stringType(),
            'PaymentMethodId' => Validator::intType(),
            'Address'         => Validator::stringType(),
            'Address2'        => Validator::optional(Validator::stringType()),
            'City'            => Validator::stringType(),
            'State'           => Validator::stringType()->uppercase()->length(2, 2),
            'Zip'             => Validator::numeric()->length(5),
            'HomePhone'       => Validator::numeric(),
            'WorkPhone'       => Validator::optional(Validator::numeric()),
            'CellPhone'       => Validator::optional(Validator::numeric()),
            'Email'           => Validator::email(),
            'Organization'    => Validator::optional(Validator::stringType()),
            'CreditCard'      => Validator::numeric()->creditCard(),
            'ExpirationDate'  => Validator::date('m/y'),
            'CID'             => Validator::numeric()->length(3, 4),
            'Amount'          => Validator::floatType(),
            'PromoCode'       => Validator::optional(Validator::stringType()),
            'LocationId'      => Validator::intType()
        ];
    }

}

/* End of ReservationPaymentAddInputModel.php */