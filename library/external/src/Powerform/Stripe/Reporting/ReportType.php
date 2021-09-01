<?php

namespace Powerform\Stripe\Reporting;

/**
 * Class ReportType
 *
 * @property string $id
 * @property string $object
 * @property int $data_available_end
 * @property int $data_available_start
 * @property string[]|null $default_columns
 * @property string $name
 * @property int $updated
 * @property int $version
 *
 * @package Powerform\Stripe\Reporting
 */
class ReportType extends \Powerform\Stripe\ApiResource
{
    const OBJECT_NAME = 'reporting.report_type';

    use \Powerform\Stripe\ApiOperations\All;
    use \Powerform\Stripe\ApiOperations\Retrieve;
}
