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
 * Class ServiceAddInputModel
 *
 * @package AdventureRes\Models\Input
 * @property int $ReservationId Set a reservation ID if one has already been created. Otherwise, set to 0.
 * @property int $CustomerId Set a customer ID if one has already been created. Otherwise, set to 0.
 * @property int $ServiceId
 * @property string $Display Defines the display time. Valid values are GROUP or ITEM.
 * @property string $ResDate Date format should be m/d/Y.
 * @property string $ScheduleTime Time format should be H:i.
 * @property int $AdultQty Required. Default value is 0.
 * @property int $YouthQty Required. Default value is 0.
 * @property int $Units Required. Default value is 0.
 */
class ServiceAddInputModel extends AbstractAdventureResModel
{
    public function __construct($attributes = null)
    {
        $this->setAttribute('ReservationId', 0);
        $this->setAttribute('CustomerId', 0);
        $this->setAttribute('AdultQty', 0);
        $this->setAttribute('YouthQty', 0);
        $this->setAttribute('Units', 0);

        parent::__construct($attributes);
    }

    protected function defineAttributes()
    {
        return [
          'ReservationId' => Validator::intType(),
          'CustomerId'    => Validator::intType(),
          'ServiceId'     => Validator::intType(),
          'Display'       => Validator::stringType()->uppercase(),
          'ResDate'       => Validator::date('m/d/Y'),
          'ScheduleTime'  => Validator::optional(Validator::date('H:i')),
          'AdultQty'      => Validator::intType(),
          'YouthQty'      => Validator::intType(),
          'Units'         => Validator::intType()
        ];
    }
}

/* End of ServiceAddInputModel.php */