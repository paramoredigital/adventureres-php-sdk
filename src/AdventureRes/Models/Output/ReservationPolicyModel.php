<?php
/**
 * Copyright 2016 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace AdventureRes\Models\Output;

use AdventureRes\Models\AbstractAdventureResModel;
use Respect\Validation\Validator;

/**
 * Class ReservationPolicyModel
 *
 * @package AdventureRes\Models\Output
 * @property string $Description
 * @property string $Details
 * @property bool $Mandatory
 */
class ReservationPolicyModel extends AbstractAdventureResModel
{
    protected function defineAttributes()
    {
        return [
          'PolicyId'    => Validator::intType(),
          'Description' => Validator::stringType(),
          'Details'     => Validator::stringType(),
          'Mandatory'   => Validator::boolType()
        ];
    }
}

/* End of ReservationPolicyModel.php */