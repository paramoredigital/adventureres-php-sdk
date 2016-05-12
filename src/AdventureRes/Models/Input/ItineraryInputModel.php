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
 * Class ItineraryInputModel
 *
 * @package AdventureRes\Models\Input
 * @property int $ReservationId
 */
class ItineraryInputModel extends AbstractAdventureResModel
{
    /**
     * {@inheritdoc}
     */
    protected function defineAttributes()
    {
        return [
          'ReservationId' => Validator::intType()
        ];
    }
}

/* End of ItineraryInputModel.php */