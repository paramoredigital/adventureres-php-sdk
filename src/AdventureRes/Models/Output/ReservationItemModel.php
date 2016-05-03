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
 * Class ReservationItemModel
 *
 * @package AdventureRes\Models\Output
 * @property int $ReservationItemId
 * @property string $Description
 * @property string $ServiceTime
 * @property float $AdultQty
 * @property float $YouthQty
 * @property float $TotalAdult
 * @property float $TotalYouth
 * @property float $TotalDiscounts
 * @property float $TotalTax
 * @property float $TotalCost
 * @property string $InvoiceComments
 * @property string $Notes
 */
class ReservationItemModel extends AbstractAdventureResModel
{
    protected function defineAttributes()
    {
        return [
          'ReservationItemId' => Validator::intType(),
          'Description'       => Validator::stringType(),
          'ServiceId'         => Validator::intType(),
          'ServiceTime'       => Validator::date('H:i'),
          'AdultQty'          => Validator::intType(),
          'YouthQty'          => Validator::intType(),
          'TotalAdult'        => Validator::floatType(),
          'TotalYouth'        => Validator::floatType(),
          'TotalDiscounts'    => Validator::floatType(),
          'TotalTax'          => Validator::floatType(),
          'TotalCost'         => Validator::floatType(),
          'InvoiceComments'   => Validator::stringType(),
          'Notes'             => Validator::stringType()
        ];
    }
}

/* End of ReservationItemModel.php */