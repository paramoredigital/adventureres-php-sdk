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
 * Class PackageModel
 * @package AdventureRes\Models\Output
 * @property int $PackageId
 * @property string $Description
 * @property float $AdultRate
 * @property float $YouthRate
 * @property string $Comment
 * @property bool $Available
 */
class PackageModel extends AbstractAdventureResModel
{
    /**
     * {@inheritdoc}
     */
    protected function defineAttributes()
    {
        return [
            'PackageId'   => Validator::numeric(),
            'Description' => Validator::stringType(),
            'AdultRate'   => Validator::optional(Validator::floatType()),
            'YouthRate'   => Validator::optional(Validator::floatType()),
            'Comment'     => Validator::optional(Validator::stringType()),
            'Available'   => Validator::boolType()
        ];
    }

}