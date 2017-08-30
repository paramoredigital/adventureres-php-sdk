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
 * @property float $ReservationPayments
 * @property float $ReservationBalance
 * @property string $Result Optional
 */
class CostSummaryModel extends AbstractAdventureResModel
{
    /**
     * {@inheritdoc}
     */
    protected function defineAttributes()
    {
        return [
            'ReservationTotalAdult'     => Validator::numeric(),
            'ReservationTotalYouth'     => Validator::numeric(),
            'ReservationTotalSubTotal'  => Validator::numeric(),
            'ReservationTotalTax'       => Validator::numeric(),
            'ReservationTotalDiscounts' => Validator::numeric(),
            'ReservationTotalCost'      => Validator::numeric(),
            'ReservationPayments'       => Validator::numeric(),
            'ReservationBalance'        => Validator::numeric(),
            'Result'                    => Validator::optional(Validator::stringType())
        ];
    }
}

/* End of CostSummaryModel.php */