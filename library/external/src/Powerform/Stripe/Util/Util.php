<?php

namespace Powerform\Stripe\Util;

use Powerform\Stripe\StripeObject;

abstract class Util
{
    private static $isMbstringAvailable = null;
    private static $isHashEqualsAvailable = null;

    /**
     * Whether the provided array (or other) is a list rather than a dictionary.
     * A list is defined as an array for which all the keys are consecutive
     * integers starting at 0. Empty arrays are considered to be lists.
     *
     * @param array|mixed $array
     * @return boolean true if the given object is a list.
     */
    public static function isList($array)
    {
        if (!is_array($array)) {
            return false;
        }
        if ($array === []) {
            return true;
        }
        if (array_keys($array) !== range(0, count($array) - 1)) {
            return false;
        }
        return true;
    }

    /**
     * Converts a response from the Stripe API to the corresponding PHP object.
     *
     * @param array $resp The response from the Stripe API.
     * @param array $opts
     * @return StripeObject|array
     */
    public static function convertToStripeObject($resp, $opts)
    {
        $types = [
            // data structures
            \Powerform\Stripe\Collection::OBJECT_NAME => \Powerform\Stripe\Collection::class,

            // business objects
            \Powerform\Stripe\Account::OBJECT_NAME => \Powerform\Stripe\Account::class,
            \Powerform\Stripe\AccountLink::OBJECT_NAME => \Powerform\Stripe\AccountLink::class,
            \Powerform\Stripe\AlipayAccount::OBJECT_NAME => \Powerform\Stripe\AlipayAccount::class,
            \Powerform\Stripe\ApplePayDomain::OBJECT_NAME => \Powerform\Stripe\ApplePayDomain::class,
            \Powerform\Stripe\ApplicationFee::OBJECT_NAME => \Powerform\Stripe\ApplicationFee::class,
            \Powerform\Stripe\ApplicationFeeRefund::OBJECT_NAME => \Powerform\Stripe\ApplicationFeeRefund::class,
            \Powerform\Stripe\Balance::OBJECT_NAME => \Powerform\Stripe\Balance::class,
            \Powerform\Stripe\BalanceTransaction::OBJECT_NAME => \Powerform\Stripe\BalanceTransaction::class,
            \Powerform\Stripe\BankAccount::OBJECT_NAME => \Powerform\Stripe\BankAccount::class,
            \Powerform\Stripe\BitcoinReceiver::OBJECT_NAME => \Powerform\Stripe\BitcoinReceiver::class,
            \Powerform\Stripe\BitcoinTransaction::OBJECT_NAME => \Powerform\Stripe\BitcoinTransaction::class,
            \Powerform\Stripe\Capability::OBJECT_NAME => \Powerform\Stripe\Capability::class,
            \Powerform\Stripe\Card::OBJECT_NAME => \Powerform\Stripe\Card::class,
            \Powerform\Stripe\Charge::OBJECT_NAME => \Powerform\Stripe\Charge::class,
            \Powerform\Stripe\Checkout\Session::OBJECT_NAME => \Powerform\Stripe\Checkout\Session::class,
            \Powerform\Stripe\CountrySpec::OBJECT_NAME => \Powerform\Stripe\CountrySpec::class,
            \Powerform\Stripe\Coupon::OBJECT_NAME => \Powerform\Stripe\Coupon::class,
            \Powerform\Stripe\CreditNote::OBJECT_NAME => \Powerform\Stripe\CreditNote::class,
            \Powerform\Stripe\CreditNoteLineItem::OBJECT_NAME => \Powerform\Stripe\CreditNoteLineItem::class,
            \Powerform\Stripe\Customer::OBJECT_NAME => \Powerform\Stripe\Customer::class,
            \Powerform\Stripe\CustomerBalanceTransaction::OBJECT_NAME => \Powerform\Stripe\CustomerBalanceTransaction::class,
            \Powerform\Stripe\Discount::OBJECT_NAME => \Powerform\Stripe\Discount::class,
            \Powerform\Stripe\Dispute::OBJECT_NAME => \Powerform\Stripe\Dispute::class,
            \Powerform\Stripe\EphemeralKey::OBJECT_NAME => \Powerform\Stripe\EphemeralKey::class,
            \Powerform\Stripe\Event::OBJECT_NAME => \Powerform\Stripe\Event::class,
            \Powerform\Stripe\ExchangeRate::OBJECT_NAME => \Powerform\Stripe\ExchangeRate::class,
            \Powerform\Stripe\File::OBJECT_NAME => \Powerform\Stripe\File::class,
            \Powerform\Stripe\File::OBJECT_NAME_ALT => \Powerform\Stripe\File::class,
            \Powerform\Stripe\FileLink::OBJECT_NAME => \Powerform\Stripe\FileLink::class,
            \Powerform\Stripe\Invoice::OBJECT_NAME => \Powerform\Stripe\Invoice::class,
            \Powerform\Stripe\InvoiceItem::OBJECT_NAME => \Powerform\Stripe\InvoiceItem::class,
            \Powerform\Stripe\InvoiceLineItem::OBJECT_NAME => \Powerform\Stripe\InvoiceLineItem::class,
            \Powerform\Stripe\Issuing\Authorization::OBJECT_NAME => \Powerform\Stripe\Issuing\Authorization::class,
            \Powerform\Stripe\Issuing\Card::OBJECT_NAME => \Powerform\Stripe\Issuing\Card::class,
            \Powerform\Stripe\Issuing\CardDetails::OBJECT_NAME => \Powerform\Stripe\Issuing\CardDetails::class,
            \Powerform\Stripe\Issuing\Cardholder::OBJECT_NAME => \Powerform\Stripe\Issuing\Cardholder::class,
            \Powerform\Stripe\Issuing\Dispute::OBJECT_NAME => \Powerform\Stripe\Issuing\Dispute::class,
            \Powerform\Stripe\Issuing\Transaction::OBJECT_NAME => \Powerform\Stripe\Issuing\Transaction::class,
            \Powerform\Stripe\LoginLink::OBJECT_NAME => \Powerform\Stripe\LoginLink::class,
            \Powerform\Stripe\Mandate::OBJECT_NAME => \Powerform\Stripe\Mandate::class,
            \Powerform\Stripe\Order::OBJECT_NAME => \Powerform\Stripe\Order::class,
            \Powerform\Stripe\OrderItem::OBJECT_NAME => \Powerform\Stripe\OrderItem::class,
            \Powerform\Stripe\OrderReturn::OBJECT_NAME => \Powerform\Stripe\OrderReturn::class,
            \Powerform\Stripe\PaymentIntent::OBJECT_NAME => \Powerform\Stripe\PaymentIntent::class,
            \Powerform\Stripe\PaymentMethod::OBJECT_NAME => \Powerform\Stripe\PaymentMethod::class,
            \Powerform\Stripe\Payout::OBJECT_NAME => \Powerform\Stripe\Payout::class,
            \Powerform\Stripe\Person::OBJECT_NAME => \Powerform\Stripe\Person::class,
            \Powerform\Stripe\Plan::OBJECT_NAME => \Powerform\Stripe\Plan::class,
            \Powerform\Stripe\Product::OBJECT_NAME => \Powerform\Stripe\Product::class,
            \Powerform\Stripe\Radar\EarlyFraudWarning::OBJECT_NAME => \Powerform\Stripe\Radar\EarlyFraudWarning::class,
            \Powerform\Stripe\Radar\ValueList::OBJECT_NAME => \Powerform\Stripe\Radar\ValueList::class,
            \Powerform\Stripe\Radar\ValueListItem::OBJECT_NAME => \Powerform\Stripe\Radar\ValueListItem::class,
            \Powerform\Stripe\Recipient::OBJECT_NAME => \Powerform\Stripe\Recipient::class,
            \Powerform\Stripe\RecipientTransfer::OBJECT_NAME => \Powerform\Stripe\RecipientTransfer::class,
            \Powerform\Stripe\Refund::OBJECT_NAME => \Powerform\Stripe\Refund::class,
            \Powerform\Stripe\Reporting\ReportRun::OBJECT_NAME => \Powerform\Stripe\Reporting\ReportRun::class,
            \Powerform\Stripe\Reporting\ReportType::OBJECT_NAME => \Powerform\Stripe\Reporting\ReportType::class,
            \Powerform\Stripe\Review::OBJECT_NAME => \Powerform\Stripe\Review::class,
            \Powerform\Stripe\SetupIntent::OBJECT_NAME => \Powerform\Stripe\SetupIntent::class,
            \Powerform\Stripe\Sigma\ScheduledQueryRun::OBJECT_NAME => \Powerform\Stripe\Sigma\ScheduledQueryRun::class,
            \Powerform\Stripe\SKU::OBJECT_NAME => \Powerform\Stripe\SKU::class,
            \Powerform\Stripe\Source::OBJECT_NAME => \Powerform\Stripe\Source::class,
            \Powerform\Stripe\SourceTransaction::OBJECT_NAME => \Powerform\Stripe\SourceTransaction::class,
            \Powerform\Stripe\Subscription::OBJECT_NAME => \Powerform\Stripe\Subscription::class,
            \Powerform\Stripe\SubscriptionItem::OBJECT_NAME => \Powerform\Stripe\SubscriptionItem::class,
            \Powerform\Stripe\SubscriptionSchedule::OBJECT_NAME => \Powerform\Stripe\SubscriptionSchedule::class,
            \Powerform\Stripe\TaxId::OBJECT_NAME => \Powerform\Stripe\TaxId::class,
            \Powerform\Stripe\TaxRate::OBJECT_NAME => \Powerform\Stripe\TaxRate::class,
            \Powerform\Stripe\ThreeDSecure::OBJECT_NAME => \Powerform\Stripe\ThreeDSecure::class,
            \Powerform\Stripe\Terminal\ConnectionToken::OBJECT_NAME => \Powerform\Stripe\Terminal\ConnectionToken::class,
            \Powerform\Stripe\Terminal\Location::OBJECT_NAME => \Powerform\Stripe\Terminal\Location::class,
            \Powerform\Stripe\Terminal\Reader::OBJECT_NAME => \Powerform\Stripe\Terminal\Reader::class,
            \Powerform\Stripe\Token::OBJECT_NAME => \Powerform\Stripe\Token::class,
            \Powerform\Stripe\Topup::OBJECT_NAME => \Powerform\Stripe\Topup::class,
            \Powerform\Stripe\Transfer::OBJECT_NAME => \Powerform\Stripe\Transfer::class,
            \Powerform\Stripe\TransferReversal::OBJECT_NAME => \Powerform\Stripe\TransferReversal::class,
            \Powerform\Stripe\UsageRecord::OBJECT_NAME => \Powerform\Stripe\UsageRecord::class,
            \Powerform\Stripe\UsageRecordSummary::OBJECT_NAME => \Powerform\Stripe\UsageRecordSummary::class,
            \Powerform\Stripe\WebhookEndpoint::OBJECT_NAME => \Powerform\Stripe\WebhookEndpoint::class,
        ];
        if (self::isList($resp)) {
            $mapped = [];
            foreach ($resp as $i) {
                array_push($mapped, self::convertToStripeObject($i, $opts));
            }
            return $mapped;
        } elseif (is_array($resp)) {
            if (isset($resp['object']) && is_string($resp['object']) && isset($types[$resp['object']])) {
                $class = $types[$resp['object']];
            } else {
                $class = \Powerform\Stripe\StripeObject::class;
            }
            return $class::constructFrom($resp, $opts);
        } else {
            return $resp;
        }
    }

    /**
     * @param string|mixed $value A string to UTF8-encode.
     *
     * @return string|mixed The UTF8-encoded string, or the object passed in if
     *    it wasn't a string.
     */
    public static function utf8($value)
    {
        if (self::$isMbstringAvailable === null) {
            self::$isMbstringAvailable = function_exists('mb_detect_encoding');

            if (!self::$isMbstringAvailable) {
                trigger_error("It looks like the mbstring extension is not enabled. " .
                    "UTF-8 strings will not properly be encoded. Ask your system " .
                    "administrator to enable the mbstring extension, or write to " .
                    "support@stripe.com if you have any questions.", E_USER_WARNING);
            }
        }

        if (is_string($value) && self::$isMbstringAvailable && mb_detect_encoding($value, "UTF-8", true) != "UTF-8") {
            return utf8_encode($value);
        } else {
            return $value;
        }
    }

    /**
     * Compares two strings for equality. The time taken is independent of the
     * number of characters that match.
     *
     * @param string $a one of the strings to compare.
     * @param string $b the other string to compare.
     * @return bool true if the strings are equal, false otherwise.
     */
    public static function secureCompare($a, $b)
    {
        if (self::$isHashEqualsAvailable === null) {
            self::$isHashEqualsAvailable = function_exists('hash_equals');
        }

        if (self::$isHashEqualsAvailable) {
            return hash_equals($a, $b);
        } else {
            if (strlen($a) != strlen($b)) {
                return false;
            }

            $result = 0;
            for ($i = 0; $i < strlen($a); $i++) {
                $result |= ord($a[$i]) ^ ord($b[$i]);
            }
            return ($result == 0);
        }
    }

    /**
     * Recursively goes through an array of parameters. If a parameter is an instance of
     * ApiResource, then it is replaced by the resource's ID.
     * Also clears out null values.
     *
     * @param mixed $h
     * @return mixed
     */
    public static function objectsToIds($h)
    {
        if ($h instanceof \Powerform\Stripe\ApiResource) {
            return $h->id;
        } elseif (static::isList($h)) {
            $results = [];
            foreach ($h as $v) {
                array_push($results, static::objectsToIds($v));
            }
            return $results;
        } elseif (is_array($h)) {
            $results = [];
            foreach ($h as $k => $v) {
                if (is_null($v)) {
                    continue;
                }
                $results[$k] = static::objectsToIds($v);
            }
            return $results;
        } else {
            return $h;
        }
    }

    /**
     * @param array $params
     *
     * @return string
     */
    public static function encodeParameters($params)
    {
        $flattenedParams = self::flattenParams($params);
        $pieces = [];
        foreach ($flattenedParams as $param) {
            list($k, $v) = $param;
            array_push($pieces, self::urlEncode($k) . '=' . self::urlEncode($v));
        }
        return implode('&', $pieces);
    }

    /**
     * @param array $params
     * @param string|null $parentKey
     *
     * @return array
     */
    public static function flattenParams($params, $parentKey = null)
    {
        $result = [];

        foreach ($params as $key => $value) {
            $calculatedKey = $parentKey ? "{$parentKey}[{$key}]" : $key;

            if (self::isList($value)) {
                $result = array_merge($result, self::flattenParamsList($value, $calculatedKey));
            } elseif (is_array($value)) {
                $result = array_merge($result, self::flattenParams($value, $calculatedKey));
            } else {
                array_push($result, [$calculatedKey, $value]);
            }
        }

        return $result;
    }

    /**
     * @param array $value
     * @param string $calculatedKey
     *
     * @return array
     */
    public static function flattenParamsList($value, $calculatedKey)
    {
        $result = [];

        foreach ($value as $i => $elem) {
            if (self::isList($elem)) {
                $result = array_merge($result, self::flattenParamsList($elem, $calculatedKey));
            } elseif (is_array($elem)) {
                $result = array_merge($result, self::flattenParams($elem, "{$calculatedKey}[{$i}]"));
            } else {
                array_push($result, ["{$calculatedKey}[{$i}]", $elem]);
            }
        }

        return $result;
    }

    /**
     * @param string $key A string to URL-encode.
     *
     * @return string The URL-encoded string.
     */
    public static function urlEncode($key)
    {
        $s = urlencode($key);

        // Don't use strict form encoding by changing the square bracket control
        // characters back to their literals. This is fine by the server, and
        // makes these parameter strings easier to read.
        $s = str_replace('%5B', '[', $s);
        $s = str_replace('%5D', ']', $s);

        return $s;
    }

    public static function normalizeId($id)
    {
        if (is_array($id)) {
            $params = $id;
            $id = $params['id'];
            unset($params['id']);
        } else {
            $params = [];
        }
        return [$id, $params];
    }

    /**
     * Returns UNIX timestamp in milliseconds
     *
     * @return integer current time in millis
     */
    public static function currentTimeMillis()
    {
        return (int) round(microtime(true) * 1000);
    }
}
