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
 * Class CostSummaryModel
 *
 * @package AdventureRes\Models\Output
 * @property float $ReservationTotalAdult
 * @property float $ReservationTotalYouth
 * @property float $ReservationTotalSubTotal
 * @property float $ReservationTotalTax
 * @property float $ReservationTotalDiscounts
 * @property float $ReservationTotalCost
 * @property float $ReservationTotalPayments
 * @property float $ReservationTotalBalance
 */
class CostSummaryModel extends AbstractAdventureResModel
{
    protected function defineAttributes()
    {
        return [
          'ReservationTotalAdult'     => Validator::floatType(),
          'ReservationTotalYouth'     => Validator::floatType(),
          'ReservationTotalSubTotal'  => Validator::floatType(),
          'ReservationTotalTax'       => Validator::floatType(),
          'ReservationTotalDiscounts' => Validator::floatType(),
          'ReservationTotalCost'      => Validator::floatType(),
          'ReservationTotalPayments'  => Validator::floatType(),
          'ReservationTotalBalance'   => Validator::floatType(),
        ];
    }
}

/* End of CostSummaryModel.php */