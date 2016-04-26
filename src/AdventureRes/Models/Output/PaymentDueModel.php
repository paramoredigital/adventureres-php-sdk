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
 * Class PaymentDueModel
 *
 * @package AdventureRes\Models\Output
 * @property int $ReservationId
 * @property float $PaymentDue
 */
class PaymentDueModel extends AbstractAdventureResModel
{
    /**
     * @inheritdoc
     */
    protected function defineAttributes()
    {
        return [
          'ReservationId' => Validator::intType(),
          'PaymentDue'    => Validator::floatType()
        ];
    }

}

/* End of PaymentDueModel.php */