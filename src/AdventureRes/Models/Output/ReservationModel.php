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
 * @package AdventureRes\Models\Output
 */
class ReservationModel extends AbstractAdventureResModel
{
    protected function defineAttributes()
    {
        return [
          'ReservationId' => Validator::intType(),
          'CustomerId'    => Validator::intType()
        ];
    }
}

/* End of ReservationModel.php */