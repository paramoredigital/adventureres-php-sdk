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
 * Class PaymentMethodModel
 *
 * @package AdventureRes\Models\Output
 * @property int $PaymentMethodId
 * @property string $CreditCard American Express, Discover, MasterCard, Visa, etc.
 * @property string $Result Optional
 */
class PaymentMethodModel extends AbstractAdventureResModel
{
    /**
     * {@inheritdoc}
     */
    protected function defineAttributes()
    {
        return [
            'PaymentMethodId' => Validator::numeric(),
            'CreditCard'      => Validator::stringType(),
            'Result'          => Validator::optional(Validator::stringType())
        ];
    }
}

/* End of PaymentMethodModel.php */