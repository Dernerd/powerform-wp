<?php

namespace Powerform\Stripe\Radar;

/**
 * Class ValueListItem
 *
 * @property string $id
 * @property string $object
 * @property int $created
 * @property string $created_by
 * @property bool $livemode
 * @property string $value
 * @property string $value_list
 *
 * @package Powerform\Stripe\Radar
 */
class ValueListItem extends \Powerform\Stripe\ApiResource
{
    const OBJECT_NAME = 'radar.value_list_item';

    use \Powerform\Stripe\ApiOperations\All;
    use \Powerform\Stripe\ApiOperations\Create;
    use \Powerform\Stripe\ApiOperations\Delete;
    use \Powerform\Stripe\ApiOperations\Retrieve;
}
