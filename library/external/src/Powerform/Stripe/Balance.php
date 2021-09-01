<?php

namespace Powerform\Stripe;

/**
 * Class Balance
 *
 * @property string $object
 * @property \Powerform\Stripe\StripeObject[] $available
 * @property \Powerform\Stripe\StripeObject[] $connect_reserved
 * @property bool $livemode
 * @property \Powerform\Stripe\StripeObject[] $pending
 *
 * @package Stripe
 */
class Balance extends SingletonApiResource
{
    const OBJECT_NAME = 'balance';

    /**
     * @param array|string|null $opts
     *
     * @throws \Powerform\Stripe\Exception\ApiErrorException if the request fails
     *
     * @return Balance
     */
    public static function retrieve($opts = null)
    {
        return self::_singletonRetrieve($opts);
    }
}
