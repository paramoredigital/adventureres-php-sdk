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
*@package AdventureRes
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
    protected function defineAttributes()
    {
        return [
          'ServiceId'             => Validator::intType(),
          'Description'           => Validator::stringType(),
          'Comment'               => Validator::optional(Validator::stringType()),
          'Image1'                => Validator::optional(Validator::stringType()),
          'Image2'                => Validator::optional(Validator::stringType()),
          'AdultRate'             => Validator::optional(Validator::floatType()),
          'YouthRate'             => Validator::optional(Validator::floatType()),
          'ClassId'               => Validator::optional(Validator::intType()),
          // Availability Params:
          'ServiceDate'           => Validator::optional(Validator::date('m/d/Y')),
          'ServiceTime'           => Validator::optional(Validator::date('H:i')),
          'ServiceScheduleItemId' => Validator::optional(Validator::intType()),
          'ShowAvailability'       => Validator::optional(Validator::boolType()),
          'Availability'           => Validator::optional(Validator::numeric()),
          'AvailabilityPercentage' => Validator::optional(Validator::numeric()),
          'DisplayType'            => Validator::optional(Validator::oneOf(
            Validator::equals('Units'),
            Validator::equals('Per-Person'),
            Validator::equals('Unavailable')))
        ];
    }
}

/* End of ServiceModel.php */