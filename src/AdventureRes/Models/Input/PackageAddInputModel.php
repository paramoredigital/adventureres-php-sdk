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
 * Class PackageAddInputModel
 * @package AdventureRes\Models\Input
 * @property int $ReservationId Set a reservation ID if one has already been created. Otherwise, set to 0.
 * @property int $CustomerId Set a customer ID if one has already been created. Otherwise, set to 0.
 * @property int $PackageId
 * @property string $ResDate Date format should be m/d/Y.
 * @property int $AdultQty Required. Default value is 0.
 * @property int $YouthQty Required. Default value is 0.
 * @property int $Units Required. Default value is 0.
 */
class PackageAddInputModel extends AbstractAdventureResModel
{
    /**
     * ServiceAddInputModel constructor.
     *
     * @param array|null $attributes
     */
    public function __construct($attributes = null)
    {
        $this->setAttribute('ReservationId', 0);
        $this->setAttribute('CustomerId', 0);
        $this->setAttribute('AdultQty', 0);
        $this->setAttribute('YouthQty', 0);
        $this->setAttribute('Units', 0);

        parent::__construct($attributes);
    }

    /**
     * {@inheritdoc}
     */
    protected function defineAttributes()
    {
        return [
            'ReservationId' => Validator::intType(),
            'CustomerId'    => Validator::intType(),
            'PackageId'     => Validator::intType(),
            'ResDate'       => Validator::date('m/d/Y'),
            'AdultQty'      => Validator::intType(),
            'YouthQty'      => Validator::intType(),
            'Units'         => Validator::intType()
        ];
    }
}