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
 * Class ReservationQuoteInputModel
 * @package AdventureRes\Models\Input
 * @property int $ReservationId
 * @property int $LocationId
 */
class ReservationQuoteInputModel extends AbstractAdventureResModel
{
    protected function defineAttributes()
    {
        return [
            'ReservationId' => Validator::intType(),
            'LocationId' => Validator::intType()
        ];
    }

}

/* End of ReservationQuoteInputModel.php */