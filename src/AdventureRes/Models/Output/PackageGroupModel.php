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
 * @property int $PackageGroupId
 * @property string $Description
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
        ];
    }

}