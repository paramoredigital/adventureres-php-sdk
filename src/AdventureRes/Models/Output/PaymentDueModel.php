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
 * @property string $Result Optional
 */
class PaymentDueModel extends AbstractAdventureResModel
{
    /**
     * {@inheritdoc}
     */
    protected function defineAttributes()
    {
        return [
            'ReservationId' => Validator::numeric(),
            'PaymentDue'    => Validator::numeric(),
            'Result'        => Validator::optional(Validator::stringType())
        ];
    }
}

/* End of PaymentDueModel.php */