<?php

namespace Powerform\Stripe\Issuing;

/**
 * Class Authorization
 *
 * @property string $id
 * @property string $object
 * @property bool $approved
 * @property string $authorization_method
 * @property int $authorized_amount
 * @property string $authorized_currency
 * @property \Powerform\Stripe\Collection $balance_transactions
 * @property Card $card
 * @property string|null $cardholder
 * @property int $created
 * @property int $held_amount
 * @property string $held_currency
 * @property bool $is_held_amount_controllable
 * @property bool $livemode
 * @property mixed $merchant_data
 * @property \Powerform\Stripe\StripeObject $metadata
 * @property int $pending_authorized_amount
 * @property int $pending_held_amount
 * @property mixed $request_history
 * @property string $status
 * @property array $transactions
 * @property mixed $verification_data
 * @property string|null $wallet_provider
 *
 * @package Powerform\Stripe\Issuing
 */
class Authorization extends \Powerform\Stripe\ApiResource
{
    const OBJECT_NAME = 'issuing.authorization';

    use \Powerform\Stripe\ApiOperations\All;
    use \Powerform\Stripe\ApiOperations\Retrieve;
    use \Powerform\Stripe\ApiOperations\Update;

    /**
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @throws \Powerform\Stripe\Exception\ApiErrorException if the request fails
     *
     * @return Authorization The approved authorization.
     */
    public function approve($params = null, $opts = null)
    {
        $url = $this->instanceUrl() . '/approve';
        list($response, $opts) = $this->_request('post', $url, $params, $opts);
        $this->refreshFrom($response, $opts);
        return $this;
    }

    /**
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @throws \Powerform\Stripe\Exception\ApiErrorException if the request fails
     *
     * @return Authorization The declined authorization.
     */
    public function decline($params = null, $opts = null)
    {
        $url = $this->instanceUrl() . '/decline';
        list($response, $opts) = $this->_request('post', $url, $params, $opts);
        $this->refreshFrom($response, $opts);
        return $this;
    }
}
