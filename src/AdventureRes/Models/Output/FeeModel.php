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
 * @property string FeeDescription
 */
class FeeModel extends AbstractAdventureResModel
{
    protected function defineAttributes()
    {
        return [
            'ReservationId' => Validator::intType(),
            'FeeDescription' => Validator::stringType()
        ];
    }
}