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
 * Class GroupListInputModel
 * @package AdventureRes\Models\Input
 * @property string $ResDate
 */
class GroupListInputModel extends AbstractAdventureResModel
{
    /**
     * {@inheritdoc}
     */
    protected function defineAttributes()
    {
        return [
            'ResDate' => Validator::date('m/d/Y'),
        ];
    }

}