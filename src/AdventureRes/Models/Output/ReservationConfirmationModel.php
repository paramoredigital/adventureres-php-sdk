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
    /**
     * {@inheritdoc}
     */
    protected function defineAttributes()
    {
        return [
          'ReservationId' => Validator::optional(Validator::numeric()),
          'Confirmation'  => Validator::optional(Validator::oneOf(Validator::stringType(), Validator::nullType())),
          'Result'        => Validator::optional(Validator::stringType())
        ];
    }

}

/* End of ReservationConfirmationModel.php */