<?php

/**
 * Copyright 2016 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace AdventureRes\Models\Output;

use AdventureRes\Models\AbstractAdventureResModel;
use Respect\Validation\Validator;

/**
 * Class ClassificationModel
 *
 * @package AdventureRes\Models\Output
 * @property int $ServiceId
 * @property string $Description
 * @property int $ClassId
 */
class ClassificationModel extends AbstractAdventureResModel
{
    /**
     * {@inheritdoc}
     */
    protected function defineAttributes()
    {
        return [
          'ServiceId'   => Validator::intType(),
          'Description' => Validator::stringType(),
          'ClassId'     => Validator::intType()
        ];
    }
}

/* End of ClassificationModel.php */