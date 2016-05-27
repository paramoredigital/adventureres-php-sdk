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
    /**
     * {@inheritdoc}
     */
    protected function defineAttributes()
    {
        return [
          'ReservationItemId' => Validator::numeric(),
          'Description'       => Validator::stringType(),
          'Comments'          => Validator::stringType(),
          'ServiceId'         => Validator::numeric(),
          'ServiceTime'       => Validator::optional(Validator::date('H:i')),
          // Legacy, perhaps? Not sure why, but it's not set in the responses...
          'ServiceDate'       => Validator::optional(Validator::date('m/d/Y H:i:s A')),
          'AdultQty'          => Validator::numeric(),
          'YouthQty'          => Validator::numeric(),
          'TotalAdult'        => Validator::numeric(),
          'TotalYouth'        => Validator::numeric(),
          'TotalDiscounts'    => Validator::numeric(),
          'TotalTax'          => Validator::numeric(),
          'TotalCost'         => Validator::numeric(),
          'InvoiceComments'   => Validator::stringType(),
          'Notes'             => Validator::stringType(),
	      'Units'             => Validator::optional(Validator::numeric()),
	      'Result'            => Validator::optional(Validator::stringType())
        ];
    }
}

/* End of ReservationItemModel.php */