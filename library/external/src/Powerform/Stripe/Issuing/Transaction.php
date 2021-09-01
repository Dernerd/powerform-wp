<?php

namespace Powerform\Stripe\Issuing;

/**
 * Class Transaction
 *
 * @property string $id
 * @property string $object
 * @property int $amount
 * @property string|null $authorization
 * @property string|null $balance_transaction
 * @property string $card
 * @property string|null $cardholder
 * @property int $created
 * @property string $currency
 * @property string|null $dispute
 * @property bool $livemode
 * @property int $merchant_amount
 * @property string $merchant_currency
 * @property \Powerform\Stripe\StripeObject $merchant_data
 * @property \Powerform\Stripe\StripeObject $metadata
 * @property string $type
 *
 * @package Powerform\Stripe\Issuing
 */
class Transaction extends \Powerform\Stripe\ApiResource
{
    const OBJECT_NAME = 'issuing.transaction';

    use \Powerform\Stripe\ApiOperations\All;
    use \Powerform\Stripe\ApiOperations\Retrieve;
    use \Powerform\Stripe\ApiOperations\Update;
}
