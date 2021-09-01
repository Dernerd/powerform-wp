<?php

namespace Powerform\Stripe\Exception\OAuth;

/**
 * Implements properties and methods common to all (non-SPL) Stripe OAuth
 * exceptions.
 */
abstract class OAuthErrorException extends \Powerform\Stripe\Exception\ApiErrorException
{
    protected function constructErrorObject()
    {
        if (is_null($this->jsonBody)) {
            return null;
        }

        return \Powerform\Stripe\OAuthErrorObject::constructFrom($this->jsonBody);
    }
}
