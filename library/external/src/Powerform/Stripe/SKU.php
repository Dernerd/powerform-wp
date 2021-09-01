<?php

namespace Powerform\Stripe;

/**
 * Class SKU
 *
 * @property string $id
 * @property string $object
 * @property bool $active
 * @property \Powerform\Stripe\StripeObject $attributes
 * @property int $created
 * @property string $currency
 * @property string|null $image
 * @property \Powerform\Stripe\StripeObject $inventory
 * @property bool $livemode
 * @property \Powerform\Stripe\StripeObject $metadata
 * @property \Powerform\Stripe\StripeObject|null $package_dimensions
 * @property int $price
 * @property string $product
 * @property int $updated
 *
 * @package Stripe
 */
class SKU extends ApiResource
{
    const OBJECT_NAME = 'sku';

    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\Delete;
    use ApiOperations\Retrieve;
    use ApiOperations\Update;
}
