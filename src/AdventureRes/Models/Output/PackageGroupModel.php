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
 * Class PackageGroupModel
 * @package AdventureRes\Models\Output
 * @property int $PackageGroupId Optional
 * @property string $Description
 * @property string $Result Optional
 */
class PackageGroupModel extends AbstractAdventureResModel
{
    /**
     * {@inheritdoc}
     */
    protected function defineAttributes()
    {
        return [
            'PackageGroupId' => Validator::optional(Validator::numeric()),
            'Description'    => Validator::stringType(),
            'Result'         => Validator::optional(Validator::stringType())
        ];
    }
}

/* End of PackageGroupModel.php */