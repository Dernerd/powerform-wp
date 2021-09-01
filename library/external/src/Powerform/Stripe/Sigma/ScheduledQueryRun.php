<?php

namespace Powerform\Stripe\Sigma;

/**
 * Class ScheduledQueryRun
 *
 * @property string $id
 * @property string $object
 * @property int $created
 * @property int $data_load_time
 * @property \Powerform\Stripe\StripeObject $error
 * @property \Powerform\Stripe\File|null $file
 * @property bool $livemode
 * @property int $result_available_until
 * @property string $sql
 * @property string $status
 * @property string $title
 *
 * @package Powerform\Stripe\Sigma
 */
class ScheduledQueryRun extends \Powerform\Stripe\ApiResource
{
    const OBJECT_NAME = 'scheduled_query_run';

    use \Powerform\Stripe\ApiOperations\All;
    use \Powerform\Stripe\ApiOperations\Retrieve;

    public static function classUrl()
    {
        return "/v1/sigma/scheduled_query_runs";
    }
}
