<?php

require_once __DIR__ . '/class-exception.php';

/**
 * Wrapper Stripe
 * Class Powerform_Gateway_Stripe
 *
 * @since 1.7
 */
class Powerform_Gateway_Stripe {

	/**
	 * Stripe Test Pub key
	 *
	 * @var string
	 */
	protected $test_key = '';

	/**
	 * Stripe Test Sec key
	 *
	 * @var string
	 */
	protected $test_secret = '';

	/**
	 * Stripe Live Pub key
	 *
	 * @var string
	 */
	protected $live_key = '';

	/**
	 * Stripe Live Sec key
	 *
	 * @var string
	 */
	protected $live_secret = '';

	/**
	 * Live Mode flag
	 *
	 * @var bool
	 */
	protected $is_live = false;

	/**
	 * Default Currency for Stripe
	 *
	 * @var string
	 */
	protected $default_currency = 'USD';

	const INVALID_TEST_SECRET_EXCEPTION = 90;
	const INVALID_LIVE_SECRET_EXCEPTION = 91;

	const INVALID_TEST_KEY_EXCEPTION = 92;
	const INVALID_LIVE_KEY_EXCEPTION = 93;

	const EMPTY_TEST_SECRET_EXCEPTION = 94;
	const EMPTY_LIVE_SECRET_EXCEPTION = 95;

	const EMPTY_TEST_KEY_EXCEPTION = 96;
	const EMPTY_LIVE_KEY_EXCEPTION = 97;

	/**
	 * Powerform_Gateway_Stripe constructor.
	 *
	 * @throws Powerform_Gateway_Exception
	 */
	public function __construct() {

		if ( ! self::is_available() ) {
			throw new Powerform_Gateway_Exception( __( 'Stripe not available, please check your WordPress installation for PHP Version and plugin conflicts.', Powerform::DOMAIN ) );
		}
		$config = get_option( 'powerform_stripe_configuration', array() );

		$this->test_key         = isset( $config['test_key'] ) ? $config['test_key'] : '';
		$this->test_secret      = isset( $config['test_secret'] ) ? $config['test_secret'] : '';
		$this->default_currency = isset( $config['default_currency'] ) ? $config['default_currency'] : 'USD';

		if ( empty( $this->test_key ) && defined( 'POWERFORM_STRIPE_TEST_KEY' ) ) {
			$this->test_key = POWERFORM_STRIPE_TEST_KEY;
		}

		if ( empty( $this->test_secret ) && defined( 'POWERFORM_STRIPE_TEST_SECRET' ) ) {
			$this->test_secret = POWERFORM_STRIPE_TEST_SECRET;
		}

		$this->live_key    = isset( $config['live_key'] ) ? $config['live_key'] : '';
		$this->live_secret = isset( $config['live_secret'] ) ? $config['live_secret'] : '';

		/**
		 * Filter CA bundle path to be used on Stripe HTTP Request
		 * Default is WP Core ca bundle path `ABSPATH . WPINC . '/certificates/ca-bundle.crt'`
		 *
		 * @param string
		 *
		 * @return string
		 */
		$stripe_ca_bundle_path = apply_filters( 'powerform_payments_stripe_ca_bundle_path', ABSPATH . WPINC . '/certificates/ca-bundle.crt' );

		\Powerform\Stripe\Stripe::setCABundlePath( $stripe_ca_bundle_path );
	}

	/**
	 * Set Stripe APP info
	 *
	 * @since 1.12
	 */
	public static function set_stripe_app_info() {
		// Send our plugin info over with the API request.
		\Powerform\Stripe\Stripe::setAppInfo(
			'WordPress Powerform',
			POWERFORM_VERSION,
			POWERFORM_PRO_URL,
			POWERFORM_STRIPE_PARTNER_ID
		);

		// Send the API info over.
		\Powerform\Stripe\Stripe::setApiVersion( POWERFORM_STRIPE_LIB_DATE );
	}

	/**
	 * @param $key
	 * @param $secret
	 * @param $error
	 *
	 * @throws Powerform_Gateway_Exception
	 */
	public static function validate_keys( $key, $secret, $error = self::INVALID_TEST_SECRET_EXCEPTION ) {
		/**
		 * You should use Checkout, Elements, or our mobile libraries to perform this process, client-side.
		 * This ensures that no sensitive card data touches your server, and allows your integration to operate in a PCI-compliant way.
		 *
		 * @see https://stripe.com/docs/api/tokens?lang=php
		 */

		try {
			\Powerform\Stripe\Stripe::setApiKey( $secret );
			self::set_stripe_app_info();

			$data = \Powerform\Stripe\Account::retrieve();

			powerform_maybe_log( __METHOD__, $data );
		} catch ( Exception $e ) {
			powerform_maybe_log( __METHOD__, $e->getMessage() );
			throw new Powerform_Gateway_Exception(
				__( 'Some error has occurred while connecting to your Stripe account. Please resolve the following errors and try to connect again.', Powerform::DOMAIN ),
				$error,
				$e
			);
		}
	}

	public static function is_available() {
		$min_php_version = apply_filters( 'powerform_payments_stripe_min_php_version', '5.6.0' );
		$loaded          = powerform_payment_lib_stripe_version_loaded();

		if ( version_compare( PHP_VERSION, $min_php_version, 'lt' ) ) {
			return false;
		}

		return $loaded;
	}

	/**
	 * @return string
	 */
	public function get_test_key() {
		return $this->test_key;
	}

	/**
	 * @return string
	 */
	public function get_test_secret() {
		return $this->test_secret;
	}

	/**
	 * @return string
	 */
	public function get_live_key() {
		return $this->live_key;
	}

	/**
	 * @return string
	 */
	public function get_live_secret() {
		return $this->live_secret;
	}

	/**
	 * @return string
	 */
	public function get_default_currency() {
		return $this->default_currency;
	}

	/**
	 * @return bool
	 */
	public function is_live() {
		return $this->is_live;
	}

	/**
	 * Store stripe settings
	 *
	 * @param $settings
	 */
	public static function store_settings( $settings ) {
		update_option( 'powerform_stripe_configuration', $settings );
	}

	/**
	 * @return bool
	 */
	public function is_live_ready() {
		return ! empty( $this->live_key ) && ! empty( $this->live_secret );
	}

	/**
	 * @return bool
	 */
	public function is_test_ready() {
		return ! empty( $this->test_key ) && ! empty( $this->test_secret );
	}

	/**
	 * @return bool
	 */
	public function is_ready() {
		if ( $this->is_live ) {
			return $this->is_live_ready();
		}

		return $this->is_test_ready();
	}

	/**
	 * @param bool $live
	 */
	public function set_live( $live ) {
		$this->is_live = $live;
	}

	/**
	 * @param $data
	 *
	 * @return \Powerform\Stripe\ApiResource
	 * @throws \Powerform\Stripe\Error\Api
	 */
	public function charge( $data ) {
		$api_key = $this->is_live() ? $this->live_secret : $this->test_secret;
		\Powerform\Stripe\Stripe::setApiKey( $api_key );
		self::set_stripe_app_info();

		return \Powerform\Stripe\Charge::create( $data );
	}

	/**
	 * @param $token
	 *
	 * @return \Powerform\Stripe\StripeObject
	 * @throws \Powerform\Stripe\Error\Api
	 */
	public function retrieve_info_from_token( $token ) {
		$api_key = $this->is_live() ? $this->live_secret : $this->test_secret;
		\Powerform\Stripe\Stripe::setApiKey( $api_key );
		self::set_stripe_app_info();

		return \Powerform\Stripe\Token::retrieve( $token );
	}

}
