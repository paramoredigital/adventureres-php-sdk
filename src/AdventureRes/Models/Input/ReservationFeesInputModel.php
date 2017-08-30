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
 * Class ReservationFeesInputModel
 * @package AdventureRes\Models\Input
 * @property int $ReservationId
 */
class ReservationFeesInputModel extends AbstractAdventureResModel
{
    protected function defineAttributes()
    {
        return [
            'ReservationId' => Validator::intType(),
        ];
    }

}

/* End of ReservationFeesInputModel.php */