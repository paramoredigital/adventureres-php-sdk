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
 * Class RemoveFeeInputModel
 * @package AdventureRes\Models\Input
 * @property int $ReservationId
 * @property string $FeeDescription
 */
class RemoveFeeInputModel extends AbstractAdventureResModel
{
    protected function defineAttributes()
    {
        return [
            'ReservationId' => Validator::intType(),
            'FeeDescription' => Validator::stringType()
        ];
    }

}