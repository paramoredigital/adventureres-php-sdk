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
 * Class ReservationConfirmationModel
 *
 * @package AdventureRes\Models\Output
 * @property int $ReservationId
 * @property string $Confirmation
 */
class ReservationConfirmationModel extends AbstractAdventureResModel
{
    protected function defineAttributes()
    {
        return [
          'ReservationId' => Validator::intType(),
          'Confirmation'  => Validator::stringType()
        ];
    }

}

/* End of ReservationConfirmationModel.php */