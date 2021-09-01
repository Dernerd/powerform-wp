<?php

namespace Powerform\Stripe\Reporting;

/**
 * Class ReportRun
 *
 * @property string $id
 * @property string $object
 * @property int $created
 * @property string|null $error
 * @property bool $livemode
 * @property \Powerform\Stripe\StripeObject $parameters
 * @property string $report_type
 * @property \Powerform\Stripe\File|null $result
 * @property string $status
 * @property int|null $succeeded_at
 *
 * @package Powerform\Stripe\Reporting
 */
class ReportRun extends \Powerform\Stripe\ApiResource
{
    const OBJECT_NAME = 'reporting.report_run';

    use \Powerform\Stripe\ApiOperations\All;
    use \Powerform\Stripe\ApiOperations\Create;
    use \Powerform\Stripe\ApiOperations\Retrieve;
}
