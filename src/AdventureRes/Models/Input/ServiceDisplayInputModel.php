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
 * Class ServiceDisplayInputModel
 *
 * @package AdventureRes\Models\Input
 * @property int $ServiceId
 */
class ServiceDisplayInputModel extends AbstractAdventureResModel
{
    /**
     * {@inheritdoc}
     */
    protected function defineAttributes()
    {
        return [
            'ServiceId' => Validator::intType()
        ];
    }
}

/* End of ServiceDisplayInputModel.php */