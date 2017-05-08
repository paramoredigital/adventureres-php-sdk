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
 * Class PackageGroupInputModel
 * @package AdventureRes\Models\Input
 * @property string $ResDate
 */
class PackageGroupInputModel extends AbstractAdventureResModel
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