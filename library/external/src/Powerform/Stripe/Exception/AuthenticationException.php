<?php

namespace Powerform\Stripe\Exception;

/**
 * AuthenticationException is thrown when invalid credentials are used to
 * connect to Stripe's servers.
 *
 * @package Powerform\Stripe\Exception
 */
class AuthenticationException extends ApiErrorException
{
}
