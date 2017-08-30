<?php
/**
 * Copyright 2017 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace AdventureRes\Models\Output;

use AdventureRes\Models\AbstractAdventureResModel;
use Respect\Validation\Validator;

/**
 * Class FeeModel
 * @package AdventureRes\Models\Output
 * @property int $ReservationId
 * @property string $FeeDescription
 * @property string $TotalFee Optional
 * @property string $Result Optional
 */
class FeeModel extends AbstractAdventureResModel
{
    protected function defineAttributes()
    {
        return [
            'ReservationId'  => Validator::intType(),
            'FeeDescription' => Validator::stringType(),
            'TotalFee'       => Validator::optional(Validator::numeric()),
            'Result'         => Validator::optional(Validator::stringType())
        ];
    }
}

/* End of FeeModel.php */