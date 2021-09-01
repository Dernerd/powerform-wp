<?php

namespace Powerform\Stripe\Radar;

/**
 * Class ValueList
 *
 * @property string $id
 * @property string $object
 * @property string $alias
 * @property int $created
 * @property string $created_by
 * @property string $item_type
 * @property \Powerform\Stripe\Collection $list_items
 * @property bool $livemode
 * @property \Powerform\Stripe\StripeObject $metadata
 * @property string $name
 *
 * @package Powerform\Stripe\Radar
 */
class ValueList extends \Powerform\Stripe\ApiResource
{
    const OBJECT_NAME = 'radar.value_list';

    use \Powerform\Stripe\ApiOperations\All;
    use \Powerform\Stripe\ApiOperations\Create;
    use \Powerform\Stripe\ApiOperations\Delete;
    use \Powerform\Stripe\ApiOperations\Retrieve;
    use \Powerform\Stripe\ApiOperations\Update;
}
