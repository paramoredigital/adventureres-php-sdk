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
    /**
     * {@inheritdoc}
     */
    protected function defineAttributes()
    {
        return [
          'ReservationTotalAdult'     => Validator::oneOf(Validator::floatType(), Validator::intType()),
          'ReservationTotalYouth'     => Validator::oneOf(Validator::floatType(), Validator::intType()),
          'ReservationTotalSubTotal'  => Validator::floatType(),
          'ReservationTotalTax'       => Validator::floatType(),
          'ReservationTotalDiscounts' => Validator::floatType(),
          'ReservationTotalCost'      => Validator::floatType(),
          'ReservationPayments'       => Validator::floatType(),
          'ReservationBalance'        => Validator::floatType(),
        ];
    }
}

/* End of CostSummaryModel.php */