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
 * Class ReservationModel

 *
*@package AdventureRes\Models\Output
 * @property int $ReservationId
 * @property int $CustomerId
 */
class ReservationModel extends AbstractAdventureResModel
{
    /**
     * {@inheritdoc}
     */
    protected function defineAttributes()
    {
        return [
          'ReservationId'   => Validator::intType(),
          'CustomerId'      => Validator::optional(Validator::intType()),
	      'Approved'        => Validator::optional(Validator::boolType()),
	      'Response'        => Validator::optional(Validator::stringType()),
	      'Authorization'   => Validator::optional(Validator::stringType()),
	      'ResponseMessage' => Validator::optional(Validator::stringType()),
	      'Amount'          => Validator::optional(Validator::oneOf(Validator::floatType(), Validator::intType())),
	      'EmailResult'     => Validator::optional(Validator::stringType()),
          'Result'          => Validator::optional(Validator::stringType())
        ];
    }
}

/* End of ReservationModel.php */