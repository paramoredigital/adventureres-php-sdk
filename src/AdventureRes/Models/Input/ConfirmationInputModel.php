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
 * Class ConfirmationInputModel
 *
 * @package AdventureRes\Models\Input
 * @property int $ReservationId
 */
class ConfirmationInputModel extends AbstractAdventureResModel
{
    /**
     * {@inheritdoc}
     */
    protected function defineAttributes()
    {
        return [
          'ReservationId' => Validator::intType(),
	      'LocationId'    => Validator::numeric()
        ];
    }
}

/* End of ItineraryInputModel.php */