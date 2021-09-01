<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Class Powerform_Page_Cache
 *
 * Powerform Page cache buster
 *
 * @since 1.6.1
 */
class Powerform_Page_Cache {

	/**
	 * Instance
	 *
	 * @var self|null
	 */
	private static $instance = null;

	public static function get_instance() {
		if ( empty( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct() {
		add_action( 'clean_post_cache', array( $this, 'on_clean_post_cache' ), 99, 2 );


		// publish action triggered by this
		add_action( 'transition_post_status', array( $this, 'on_transition_post_status' ), 99, 3 );
	}

	/**
	 * Fired when `clean_post_cache` action
	 *
	 * @param int     $post_id
	 * @param WP_Post $post
	 */
	public function on_clean_post_cache( $post_id, $post ) {
		powerform_maybe_log( __METHOD__, $post_id );
		$this->execute_page_caches( $post_id, $post );
	}

	/**
	 * Fired when `transition_post_status` action
	 *
	 * @param         $new_status
	 * @param         $old_status
	 * @param WP_Post $post
	 */
	public function on_transition_post_status( $new_status, $old_status, $post ) {
		// no status changed
		if ( $new_status === $old_status ) {
			return;
		}

		$post_id = null;
		if ( $post instanceof WP_Post ) {
			$post_id = $post->ID;
			powerform_maybe_log( __METHOD__, $post_id );
		}

		$this->execute_page_caches( $post_id, $post );
	}

	/**
	 * Main logic on how to handle page caches busting
	 *
	 * @param $post_id
	 * @param $post
	 */
	public function execute_page_caches( $post_id, $post ) {
		// get fresh post
		$wp_post = get_post( $post_id );

		// this is deleted / invalid post
		if ( ! $wp_post instanceof WP_Post ) {
			$this->remove_powerform_module_from_posts_map( $post_id );
			$this->remove_post_from_posts_map( $post_id );

			return;
		}

		if ( 'auto-draft' === $wp_post->post_status ) {
			return;
		}

		if ( 'revision' === $wp_post->post_type ) {
			return;
		}

		$powerform_post_types = $this->get_powerform_post_types();
		if ( in_array( $post->post_type, $powerform_post_types, true ) ) {
			$this->maybe_bust_cache_posts( $post_id, $post );
		} else {
			$this->maybe_update_posts_map_option( $post_id, $post );
		}
	}

	/**
	 * Get internal powerform post types
	 *
	 * @return array
	 */
	public function get_powerform_post_types() {
		$post_types = array(
			Powerform_Custom_Form_Model::model()->get_post_type(),
			Powerform_Poll_Form_Model::model()->get_post_type(),
			Powerform_Quiz_Form_Model::model()->get_post_type(),
		);

		/**
		 * Filter powerform post types that used as reference on page cache buster
		 *
		 * @since 1.6
		 *
		 * @param array $post_types
		 *
		 * @return array
		 */
		$post_types = apply_filters( 'powerform_page_cache_get_powerform_post_types', $post_types );

		return $post_types;
	}

	/**
	 * Bust cache of post which have powerform inside it
	 *
	 * @param         $post_id
	 * @param WP_Post $post
	 */
	public function maybe_bust_cache_posts( $post_id, $post ) {
		powerform_maybe_log( __METHOD__, $post_id );
		$module_id = (int) $post_id;
		$option    = get_option( 'powerform_posts_map', array() );

		$to_bust_cache_post_ids = isset( $option[ $module_id ] ) ? $option[ $module_id ] : array();

		foreach ( $to_bust_cache_post_ids as $to_bust_cache_post_id ) {
			$this->bust_cache_post( $to_bust_cache_post_id );
		}
	}

	/**
	 * Update posts map
	 *
	 * @param int     $post_id
	 * @param WP_Post $post
	 */
	public function maybe_update_posts_map_option( $post_id, $post ) {

		powerform_maybe_log( __METHOD__, $post_id );
		$posts_map_option = get_option( 'powerform_posts_map', array() );
		$post_id          = (int) $post_id;
		$content          = $post->post_content;

		if ( has_shortcode( $content, 'powerform_form' )
		     || has_shortcode( $content, 'powerform_poll' )
		     || has_shortcode( $content, 'powerform_quiz' )
		) {

			$module_ids      = array();
			$shortcode_regex = get_shortcode_regex( array( 'powerform_form', 'powerform_poll', 'powerform_quiz' ) );

			preg_match_all( '/' . $shortcode_regex . '/', $content, $matches, PREG_SET_ORDER );

			if ( empty( $matches ) ) {
				return;
			}

			foreach ( $matches as $match ) {
				$shortcode_attr_text = isset( $match[3] ) ? $match[3] : '';
				if ( empty( $shortcode_attr_text ) ) {
					continue;
				}


				$attr = shortcode_parse_atts( $shortcode_attr_text );

				if ( isset( $attr['id'] ) ) {
					$module_ids[] = (int) $attr['id'];
				}

			}

			$module_ids = array_unique( $module_ids, SORT_NUMERIC );

			// Add
			foreach ( $module_ids as $module_id ) {
				$module_id = (int) $module_id;
				if ( ! isset( $posts_map_option[ $module_id ] ) ) {
					$posts_map_option[ $module_id ] = array();
				}

				$module_posts_map = $posts_map_option[ $module_id ];
				if ( ! in_array( $post_id, $module_posts_map, true ) ) {
					$module_posts_map[] = $post_id;
					sort( $module_posts_map );
					$posts_map_option[ $module_id ] = $module_posts_map;
				}
			}

			// Cleanup
			foreach ( $posts_map_option as $module_id => $saved_post_ids ) {
				foreach ( $saved_post_ids as $saved_post_id ) {
					if ( $post_id === $saved_post_id ) {
						$saved_module_id = (int) $module_id;

						// this post does not have `saved_module_id` anymore
						if ( ! in_array( $saved_module_id, $module_ids, true ) ) {
							$post_ids = array_diff( $saved_post_ids, array( $post_id ) );
							sort( $post_ids );
							if ( empty( $post_ids ) ) {
								unset( $posts_map_option[ $module_id ] );
							} else {
								$posts_map_option[ $module_id ] = $post_ids;
							}

						}
					}
				}

			}


		} else {
			// Cleanup
			foreach ( $posts_map_option as $module_id => $saved_post_ids ) {
				foreach ( $saved_post_ids as $saved_post_id ) {
					if ( $post_id === $saved_post_id ) {
						// this post does not have `powerform` anymore
						$post_ids = array_diff( $saved_post_ids, array( $post_id ) );
						sort( $post_ids );
						if ( empty( $post_ids ) ) {
							unset( $posts_map_option[ $module_id ] );
						} else {
							$posts_map_option[ $module_id ] = $post_ids;
						}

					}
				}

			}
		}

		update_option( 'powerform_posts_map', $posts_map_option );
	}

	/**
	 * Remove powerform module from posts_map
	 *
	 * @param $module_id
	 */
	public function remove_powerform_module_from_posts_map( $module_id ) {
		$module_id = (int) $module_id;
		$option    = get_option( 'powerform_posts_map', array() );

		if ( isset( $option[ $module_id ] ) ) {
			if ( is_array( $option[ $module_id ] ) ) {
				$to_bust_cache_post_ids = $option[ $module_id ];
				foreach ( $to_bust_cache_post_ids as $to_bust_cache_post_id ) {
					$this->bust_cache_post( $to_bust_cache_post_id );
				}
			}
		}

		unset( $option[ $module_id ] );
		update_option( 'powerform_posts_map', $option );
	}

	/**
	 * Remove post from posts map
	 *
	 * @param $post_id_to_remove
	 */
	public function remove_post_from_posts_map( $post_id_to_remove ) {
		$post_id_to_remove = (int) $post_id_to_remove;
		$option            = get_option( 'powerform_posts_map', array() );

		foreach ( $option as $module_id => $post_ids ) {
			if ( in_array( $post_id_to_remove, $post_ids, true ) ) {
				$post_ids = array_diff( $post_ids, array( $post_id_to_remove ) );
				sort( $post_ids );

				if ( empty( $post_ids ) ) {
					unset( $option[ $module_id ] );
				} else {
					$option[ $module_id ] = $post_ids;
				}
			}
		}

		update_option( 'powerform_posts_map', $option );
	}

	/**
	 * Bust cache
	 *
	 * @param $to_bust_cache_post_id
	 */
	public function bust_cache_post( $to_bust_cache_post_id ) {
		if ( function_exists( 'clean_post_cache' ) ) {
			powerform_maybe_log( 'clean_post_cache exists' );
			// w3-total-cache use `clean_post_cache`
			clean_post_cache( $to_bust_cache_post_id );
		}

		// hummingbird
		do_action( 'wphb_clear_page_cache', $to_bust_cache_post_id );
	}

}

// init
Powerform_Page_Cache::get_instance();
