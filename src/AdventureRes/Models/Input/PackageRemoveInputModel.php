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
 * Class PackageRemoveInputModel
 * @package AdventureRes\Models\Input
 * @property int $ReservationId
 * @property int $ReservationPackageItemId
 */
class PackageRemoveInputModel extends AbstractAdventureResModel
{
    /**
     * {@inheritdoc}
     */
    protected function defineAttributes()
    {
        return [
            'ReservationId' => Validator::intType(),
            'ReservationPackageItemId' => Validator::intType()
        ];
    }
}

/* End of PackageRemoveInputModel.php */