<?php

namespace Powerform\Stripe\Terminal;

/**
 * Class Reader
 *
 * @property string $id
 * @property string $object
 * @property string|null $device_sw_version
 * @property string $device_type
 * @property string|null $ip_address
 * @property string $label
 * @property bool $livemode
 * @property string|null $location
 * @property \Powerform\Stripe\StripeObject $metadata
 * @property string $serial_number
 * @property string|null $status
 *
 * @package Powerform\Stripe\Terminal
 */
class Reader extends \Powerform\Stripe\ApiResource
{
    const OBJECT_NAME = 'terminal.reader';

    use \Powerform\Stripe\ApiOperations\All;
    use \Powerform\Stripe\ApiOperations\Create;
    use \Powerform\Stripe\ApiOperations\Delete;
    use \Powerform\Stripe\ApiOperations\Retrieve;
    use \Powerform\Stripe\ApiOperations\Update;
}
