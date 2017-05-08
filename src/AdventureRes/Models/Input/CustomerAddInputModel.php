<?php
/**
 * Copyright 2017 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace AdventureRes\Models\Input;


use AdventureRes\Models\AbstractAdventureResModel;
use Respect\Validation\Validator;

/**
 * Class CustomerAddInputModel
 * @package AdventureRes\Models\Input
 * @property int $ReservationId
 * @property int $CustomerId
 * @property string $FirstName
 * @property string $LastName
 * @property string $OrgName
 * @property string $Address
 * @property string $Address2 Optional
 * @property string $City
 * @property string $State
 * @property string $Zip
 * @property string $Country
 * @property string $DOB
 * @property int $Age
 * @property string $Gender
 * @property string $HomePhone
 * @property string $WorkPhone
 * @property string $CellPhone
 * @property string $Email
 * @property int $GroupTypeId
 * @property int $HTHId
 */
class CustomerAddInputModel extends AbstractAdventureResModel
{
    protected function defineAttributes()
    {
        return [
            'ReservationId' => Validator::optional(Validator::intType()),
            'CustomerId'    => Validator::optional(Validator::intType()),
            'FirstName'     => Validator::stringType(),
            'LastName'      => Validator::stringType(),
            'OrgName'       => Validator::stringType(),
            'Address'       => Validator::stringType(),
            'Address2'      => Validator::stringType(),
            'City'          => Validator::stringType(),
            'State'         => Validator::stringType()->uppercase()->length(2, 2),
            'Zip'           => Validator::numeric()->length(5),
            'Country'       => Validator::stringType(),
            'DOB'           => Validator::date('m/d/Y'),
//            'Age'           => Validator::intType(),
            'Gender'        => Validator::stringType(),
            'HomePhone'     => Validator::numeric(),
            'WorkPhone'     => Validator::numeric(),
            'CellPhone'     => Validator::numeric(),
            'Email'         => Validator::email(),
//            'GroupTypeId'   => Validator::intType(),
//            'HTHId'         => Validator::intType(),
        ];
    }
}