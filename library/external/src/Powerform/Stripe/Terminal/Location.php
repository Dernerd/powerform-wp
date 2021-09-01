<?php

namespace Powerform\Stripe\Terminal;

/**
 * Class Location
 *
 * @property string $id
 * @property string $object
 * @property \Powerform\Stripe\StripeObject $address
 * @property string $display_name
 * @property bool $livemode
 * @property \Powerform\Stripe\StripeObject $metadata
 *
 * @package Powerform\Stripe\Terminal
 */
class Location extends \Powerform\Stripe\ApiResource
{
    const OBJECT_NAME = 'terminal.location';

    use \Powerform\Stripe\ApiOperations\All;
    use \Powerform\Stripe\ApiOperations\Create;
    use \Powerform\Stripe\ApiOperations\Delete;
    use \Powerform\Stripe\ApiOperations\Retrieve;
    use \Powerform\Stripe\ApiOperations\Update;
}
