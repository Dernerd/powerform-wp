<?php

namespace Powerform\Stripe\Issuing;

/**
 * Class Dispute
 *
 * @property string $id
 * @property string $object
 * @property int $amount
 * @property int $created
 * @property string $currency
 * @property string $disputed_transaction
 * @property \Powerform\Stripe\StripeObject $evidence
 * @property bool $livemode
 * @property \Powerform\Stripe\StripeObject $metadata
 * @property string $reason
 * @property string $status
 *
 * @package Powerform\Stripe\Issuing
 */
class Dispute extends \Powerform\Stripe\ApiResource
{
    const OBJECT_NAME = 'issuing.dispute';

    use \Powerform\Stripe\ApiOperations\All;
    use \Powerform\Stripe\ApiOperations\Create;
    use \Powerform\Stripe\ApiOperations\Retrieve;
    use \Powerform\Stripe\ApiOperations\Update;
}
