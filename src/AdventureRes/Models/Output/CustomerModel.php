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
 * Class CustomerModel
 * @package AdventureRes\Models\Output
 * @property int $CustomerId
 */
class CustomerModel extends AbstractAdventureResModel
{
    protected function defineAttributes()
    {
        return [
            'CustomerId' => Validator::intType()
        ];
    }
}