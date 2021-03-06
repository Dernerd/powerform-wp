<?php

namespace Powerform\Stripe;

/**
 * Class InvoiceItem
 *
 * @property string $id
 * @property string $object
 * @property int $amount
 * @property string $currency
 * @property string $customer
 * @property int $date
 * @property string|null $description
 * @property bool $discountable
 * @property string|null $invoice
 * @property bool $livemode
 * @property \Powerform\Stripe\StripeObject $metadata
 * @property \Powerform\Stripe\StripeObject $period
 * @property \Powerform\Stripe\Plan|null $plan
 * @property bool $proration
 * @property int $quantity
 * @property string|null $subscription
 * @property string $subscription_item
 * @property \Powerform\Stripe\TaxRate[]|null $tax_rates
 * @property bool $unified_proration
 * @property int|null $unit_amount
 * @property string|null $unit_amount_decimal
 *
 * @package Stripe
 */
class InvoiceItem extends ApiResource
{
    const OBJECT_NAME = 'invoiceitem';

    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\Delete;
    use ApiOperations\Retrieve;
    use ApiOperations\Update;
}
