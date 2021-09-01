<?php

namespace Powerform\Stripe\Exception;

/**
 * ApiConnection is thrown in the event that the SDK can't connect to Stripe's
 * servers. That can be for a variety of different reasons from a downed
 * network to a bad TLS certificate.
 *
 * @package Powerform\Stripe\Exception
 */
class ApiConnectionException extends ApiErrorException
{
}
