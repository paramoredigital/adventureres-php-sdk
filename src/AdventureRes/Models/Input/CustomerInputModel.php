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
 * Class CustomerInputModel
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
class CustomerInputModel extends AbstractAdventureResModel
{
    protected function defineAttributes()
    {
        return [
            'ReservationId' => Validator::intType(),
            'CustomerId'    => Validator::intType(),
            'FirstName'     => Validator::stringType(),
            'LastName'      => Validator::stringType(),
            'OrgName'       => Validator::optional(Validator::stringType()),
            'Address'       => Validator::optional(Validator::stringType()),
            'Address2'      => Validator::optional(Validator::stringType()),
            'City'          => Validator::optional(Validator::stringType()),
            'State'         => Validator::optional(Validator::stringType()->uppercase()->length(2, 2)),
            'Zip'           => Validator::optional(Validator::numeric()->length(5)),
            'Country'       => Validator::optional(Validator::stringType()),
            'DOB'           => Validator::optional(Validator::date('m/d/Y')),
            'Age'           => Validator::optional(Validator::intType()),
            'Gender'        => Validator::optional(Validator::stringType()),
            'HomePhone'     => Validator::optional(Validator::numeric()),
            'WorkPhone'     => Validator::optional(Validator::numeric()),
            'CellPhone'     => Validator::optional(Validator::numeric()),
            'Email'         => Validator::email(),
            'GroupTypeId'   => Validator::intType(),
            'HTHId'         => Validator::intType(),
        ];
    }
}