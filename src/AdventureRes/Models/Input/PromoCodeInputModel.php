<?php
/**
 * Copyright 2016 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace AdventureRes\Models\Input;

use AdventureRes\Models\AbstractAdventureResModel;
use Respect\Validation\Validator;

/**
 * Class PromoCodeInputModel
 *
 * @package AdventureRes\Models\Input
 * @property int $ReservationId
 * @property string $PromoCode
 */
class PromoCodeInputModel extends AbstractAdventureResModel
{
    /**
     * {@inheritdoc}
     */
    protected function defineAttributes()
    {
        return [
          'ReservationId' => Validator::intType(),
          'PromoCode'     => Validator::stringType()
        ];
    }

}

/* End of PromoCodeInputModel.php */