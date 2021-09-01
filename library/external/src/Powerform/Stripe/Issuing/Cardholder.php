<?php

namespace Powerform\Stripe\Issuing;

/**
 * Class Cardholder
 *
 * @property string $id
 * @property string $object
 * @property \Powerform\Stripe\StripeObject|null $authorization_controls
 * @property \Powerform\Stripe\StripeObject $billing
 * @property \Powerform\Stripe\StripeObject|null $company
 * @property int $created
 * @property string|null $email
 * @property \Powerform\Stripe\StripeObject|null $individual
 * @property bool $is_default
 * @property bool $livemode
 * @property \Powerform\Stripe\StripeObject $metadata
 * @property string $name
 * @property string|null $phone_number
 * @property \Powerform\Stripe\StripeObject $requirements
 * @property string $status
 * @property string $type
 *
 * @package Powerform\Stripe\Issuing
 */
class Cardholder extends \Powerform\Stripe\ApiResource
{
    const OBJECT_NAME = 'issuing.cardholder';

    use \Powerform\Stripe\ApiOperations\All;
    use \Powerform\Stripe\ApiOperations\Create;
    use \Powerform\Stripe\ApiOperations\Retrieve;
    use \Powerform\Stripe\ApiOperations\Update;
}
