<?php

namespace Powerform\Stripe\ApiOperations;

/**
 * Trait for listable resources. Adds a `all()` static method to the class.
 *
 * This trait should only be applied to classes that derive from StripeObject.
 */
trait All
{
    /**
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @throws \Powerform\Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Powerform\Stripe\Collection of ApiResources
     */
    public static function all($params = null, $opts = null)
    {
        self::_validateParams($params);
        $url = static::classUrl();

        list($response, $opts) = static::_staticRequest('get', $url, $params, $opts);
        $obj = \Powerform\Stripe\Util\Util::convertToStripeObject($response->json, $opts);
        if (!($obj instanceof \Powerform\Stripe\Collection)) {
            throw new \Powerform\Stripe\Exception\UnexpectedValueException(
                'Expected type ' . \Powerform\Stripe\Collection::class . ', got "' . get_class($obj) . '" instead.'
            );
        }
        $obj->setLastResponse($response);
        $obj->setFilters($params);
        return $obj;
    }
}
