<?php

/**
 * Check if stripe payment lib loaded
 *
 * @since 1.7.0
 *
 * @param string $version
 *
 * @return bool
 */
function powerform_payment_lib_stripe_version_loaded( $version = POWERFORM_STRIPE_LIB_VERSION ) {
	$loaded          = false;
	$min_php_version = apply_filters( 'powerform_payments_stripe_min_php_version', '5.6.0' );

	if ( version_compare( PHP_VERSION, $min_php_version, 'ge' ) ) {
		if ( class_exists( '\Powerform\Stripe\Stripe' ) ) {
			if ( defined( '\Powerform\Stripe\Stripe::VERSION' ) ) {
				$loaded = \Powerform\Stripe\Stripe::VERSION === $version;
			}
		}
	}

	return $loaded;
}

/**
 * Get stripe php lib version
 *
 * @since 1.7.0
 * @return int|string
 */
function powerform_payment_lib_stripe_get_version() {
	if ( powerform_payment_lib_stripe_version_loaded() ) {
		return \Powerform\Stripe\Stripe::VERSION;
	}

	return 0;
}

/**
 * Check if PayPal payment lib loaded
 *
 * @since 1.7.1
 *
 * @param string $version
 *
 * @return bool
 */
function powerform_payment_lib_paypal_version_loaded( $version = POWERFORM_PAYPAL_LIB_VERSION ) {
	$loaded          = false;
	$min_php_version = apply_filters( 'powerform_payments_paypal_min_php_version', '5.3' );

	if ( version_compare( PHP_VERSION, $min_php_version, 'ge' ) ) {
		if ( class_exists( '\Powerform\PayPal\Core\PayPalConstants' ) ) {
			if ( defined( '\Powerform\PayPal\Core\PayPalConstants::SDK_VERSION' ) ) {
				$loaded = \Powerform\PayPal\Core\PayPalConstants::SDK_VERSION === $version;
			}
		}
	}

	return $loaded;
}
