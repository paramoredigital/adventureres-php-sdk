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
 * Class ServiceRemoveInputModel
 *
 * @package AdventureRes\Models\Input
 * @property int $ReservationItemId
 */
class ServiceRemoveInputModel extends AbstractAdventureResModel
{
    protected function defineAttributes()
    {
        return [
          'ReservationItemId' => Validator::intType()
        ];
    }
}

/* End of ServiceRemoveInputModel.php */