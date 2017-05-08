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
 * Class ReservationModel
 *
 * @package AdventureRes\Models\Output
 * @property int $ReservationId
 * @property int $CustomerId Optional
 * @property string $PackageString Optional
 * @property bool $Available Optional
 * @property string $Comment Optional
 */
class ReservationModel extends AbstractAdventureResModel
{
    /**
     * {@inheritdoc}
     */
    protected function defineAttributes()
    {
        return [
            'ReservationId' => Validator::intType(),
            'CustomerId'    => Validator::optional(Validator::intType()),
            'PackageString' => Validator::optional(Validator::stringType()),
            'Available'     => Validator::optional(Validator::boolType()),
            'Comment'       => Validator::optional(Validator::stringType())
        ];
    }
}

/* End of ReservationModel.php */