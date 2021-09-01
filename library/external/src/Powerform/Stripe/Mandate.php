<?php

namespace Powerform\Stripe;

/**
 * Class Mandate
 *
 * @property string $id
 * @property string $object
 * @property \Powerform\Stripe\StripeObject $customer_acceptance
 * @property bool $livemode
 * @property \Powerform\Stripe\StripeObject $multi_use
 * @property string $payment_method
 * @property \Powerform\Stripe\StripeObject $payment_method_details
 * @property \Powerform\Stripe\StripeObject $single_use
 * @property string $status
 * @property string $type
 *
 * @package Stripe
 */
class Mandate extends ApiResource
{
    const OBJECT_NAME = 'mandate';

    use ApiOperations\Retrieve;
}
