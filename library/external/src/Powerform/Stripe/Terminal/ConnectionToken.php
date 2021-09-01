<?php

namespace Powerform\Stripe\Terminal;

/**
 * Class ConnectionToken
 *
 * @property string $object
 * @property string $location
 * @property string $secret
 *
 * @package Powerform\Stripe\Terminal
 */
class ConnectionToken extends \Powerform\Stripe\ApiResource
{
    const OBJECT_NAME = 'terminal.connection_token';

    use \Powerform\Stripe\ApiOperations\Create;
}
