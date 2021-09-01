<?php

namespace Powerform\Stripe\Exception;

/**
 * IdempotencyException is thrown in cases where an idempotency key was used
 * improperly.
 *
 * @package Powerform\Stripe\Exception
 */
class IdempotencyException extends ApiErrorException
{
}
