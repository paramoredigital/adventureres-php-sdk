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
 * Class PackageAvailabilityInputModel
 * @package AdventureRes\Models\Input
 * @property int $PackageGroupId
 * @property string $ResDate
 * @property int $AdultQty Required. Default value is 0.
 * @property int $YouthQty Required. Default value is 0.
 * @property int $Units Required. Default value is 0.
 */
class PackageAvailabilityInputModel extends AbstractAdventureResModel
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

    protected function defineAttributes()
    {
        return [
            'PackageGroupId' => Validator::intType(),
            'AdultQty'       => Validator::intType(),
            'YouthQty'       => Validator::intType(),
            'Units'          => Validator::intType(),
            'ResDate'        => Validator::date('m/d/Y'),
        ];
    }

}