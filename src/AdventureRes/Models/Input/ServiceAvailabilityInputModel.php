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
 * Class ServiceAvailabilityInputModel
 *
 * @package AdventureRes\Models\Input
 * @property int $ServiceId Can be a service ID or a service group ID.
 * @property int $LocationId
 * @property int $AdultQty Required. Default value is 0.
 * @property int $YouthQty Required. Default value is 0.
 * @property int $Units Required. Default value is 0.
 * @property string $StartDate
 * @property string $Session
 * @property string $Display Default is group availability. Values: GROUP or ITEM.
 */
class ServiceAvailabilityInputModel extends AbstractAdventureResModel
{
    /**
     * ServiceAvailabilityInputModel constructor.
     *
     * @param null $attributes
     */
    public function __construct($attributes = null)
    {
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
          'ServiceId'  => Validator::intType(),
          'AdultQty'   => Validator::intType(),
          'YouthQty'   => Validator::intType(),
          'Units'      => Validator::intType(),
          'StartDate'  => Validator::date('m/d/Y'),
          'Display'    => Validator::stringType()->uppercase()->oneOf(
            Validator::equals('GROUP'),
            Validator::equals('ITEM'))
        ];
    }
}

/* End of ServiceAvailabilityInputModel.php */