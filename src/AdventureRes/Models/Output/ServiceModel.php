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
 * Class ServiceModel
 *
 * @package AdventureRes\Models\Output
 * @property int $ServiceId
 * @property string $Description
 * @property string $Comment
 * @property string $Image1
 * @property string $Image2
 * @property float $AdultRate
 * @property float $YouthRate
 * @property int $ClassId
 * @property string $ServiceDate Date format: m/d/Y
 * @property string $ServiceTime
 * @property int $ServiceScheduleItemId
 * @property bool $ShowAvailability
 * @property int $Availability
 * @property int $AvailabilityPercentage
 * @property string $DisplayType (Units, Per-Person, Unavailable)
 */
class ServiceModel extends AbstractAdventureResModel
{
    /**
     * {@inheritdoc}
     */
    protected function defineAttributes()
    {
        return [
          'ServiceId'              => Validator::numeric(),
          'Description'            => Validator::stringType(),
          'Comment'                => Validator::optional(Validator::stringType()),
          'Image1'                 => Validator::optional(Validator::stringType()),
          'Image2'                 => Validator::optional(Validator::stringType()),
          'AdultRate'              => Validator::optional(Validator::numeric()),
          'YouthRate'              => Validator::optional(Validator::numeric()),
          'ClassId'                => Validator::optional(Validator::numeric()),
          // Availability Params:
          'ServiceDate'            => Validator::optional(Validator::date('m/d/Y')),
          'ServiceTime'            => Validator::optional(Validator::date('H:i')),
          'ServiceScheduleItemId'  => Validator::optional(Validator::intType()),
          'ShowAvailability'       => Validator::optional(Validator::boolType()),
          'Availability'           => Validator::optional(Validator::numeric()),
          'AvailabilityPercentage' => Validator::optional(Validator::numeric()),
          'DisplayType'            => Validator::optional(Validator::oneOf(
            Validator::equals('Units'),
            Validator::equals('Per-Person'),
            Validator::equals('Unavailable'))),
	      'UnitsRequired'          => Validator::optional(Validator::numeric()),
	      'Result'          => Validator::optional(Validator::stringType())
        ];
    }
}

/* End of ServiceModel.php */