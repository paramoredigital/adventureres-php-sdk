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
 * Class PackageDisplayInputModel
 * @package AdventureRes\Models\Input
 * @property int $PackageId
 */
class PackageDisplayInputModel extends AbstractAdventureResModel
{
    /**
     * {@inheritdoc}
     */
    protected function defineAttributes()
    {
        return [
            'PackageId' => Validator::intType()
        ];
    }
}

/* End of PackageDisplayInputModel.php */