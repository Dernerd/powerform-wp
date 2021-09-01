<?php

namespace Powerform\Stripe\Issuing;

/**
 * Class Card
 *
 * @property string $id
 * @property string $object
 * @property \Powerform\Stripe\StripeObject $authorization_controls
 * @property string $brand
 * @property \Powerform\Stripe\Issuing\Cardholder|null $cardholder
 * @property int $created
 * @property string $currency
 * @property int $exp_month
 * @property int $exp_year
 * @property string $last4
 * @property bool $livemode
 * @property \Powerform\Stripe\StripeObject $metadata
 * @property string $name
 * @property \Powerform\Stripe\StripeObject|null $pin
 * @property string|null $replacement_for
 * @property string|null $replacement_reason
 * @property \Powerform\Stripe\StripeObject|null $shipping
 * @property string $status
 * @property string $type
 *
 * @package Powerform\Stripe\Issuing
 */
class Card extends \Powerform\Stripe\ApiResource
{
    const OBJECT_NAME = 'issuing.card';

    use \Powerform\Stripe\ApiOperations\All;
    use \Powerform\Stripe\ApiOperations\Create;
    use \Powerform\Stripe\ApiOperations\Retrieve;
    use \Powerform\Stripe\ApiOperations\Update;

    /**
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @throws \Powerform\Stripe\Exception\ApiErrorException if the request fails
     *
     * @return CardDetails The card details associated with that issuing card.
     */
    public function details($params = null, $opts = null)
    {
        $url = $this->instanceUrl() . '/details';
        list($response, $opts) = $this->_request('get', $url, $params, $opts);
        $obj = \Powerform\Stripe\Util\Util::convertToStripeObject($response, $opts);
        $obj->setLastResponse($response);
        return $obj;
    }
}
