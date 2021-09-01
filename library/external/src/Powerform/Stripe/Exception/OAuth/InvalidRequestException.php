<?php

namespace Powerform\Stripe\Exception\OAuth;

/**
 * InvalidRequestException is thrown when a code, refresh token, or grant
 * type parameter is not provided, but was required.
 *
 * @package Powerform\Stripe\Exception\OAuth
 */
class InvalidRequestException extends OAuthErrorException
{
}
