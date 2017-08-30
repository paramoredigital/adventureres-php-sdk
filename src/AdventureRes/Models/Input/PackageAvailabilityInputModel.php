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
 * @property int $PackageId Optional
 * @property int $PackageGroupId
 * @property string $ResDate Date format is m/d/Y
 * @property int $LocationId
 * @property int $AdultQty Default value is 0.
 * @property int $YouthQty Default value is 0.
 * @property int $Units Default value is 0.
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

    /**
     * {@inheritdoc}
     */
    protected function defineAttributes()
    {
        return [
            'PackageId'      => Validator::optional(Validator::intType()),
            'PackageGroupId' => Validator::intType(),
            'ResDate'        => Validator::date('m/d/Y'),
            'LocationId'     => Validator::intType(),
            'AdultQty'       => Validator::intType(),
            'YouthQty'       => Validator::intType(),
            'Units'          => Validator::intType(),
        ];
    }

}

/* End of PackageAvailabilityInputModel.php */