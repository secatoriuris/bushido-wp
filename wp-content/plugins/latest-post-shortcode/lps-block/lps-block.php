<?php
/**
 * Latest Post Shortcode Block.
 * Text Domain: lps
 *
 * @package lps
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'init', 'latest_post_shortcode_lps_block_block_init' );
add_action( 'after_setup_theme', 'lps_add_theme_support' );
add_action( 'init', 'lps_set_script_translations', 30 );

if ( ! function_exists( 'lps_set_script_translations' ) ) {
	/**
	 * Set script translations.
	 *
	 * @return void
	 */
	function lps_set_script_translations() {
		wp_set_script_translations( 'latest-post-shortcode-lps-block-editor', 'lps' );
	}
}

if ( ! function_exists( 'latest_post_shortcode_lps_block_block_init' ) ) {
	/**
	 * Registers all block assets so that they can be enqueued through the block editor
	 * in the corresponding context.
	 *
	 * @see https://developer.wordpress.org/block-editor/tutorials/block-tutorial/applying-styles-with-stylesheets/
	 */
	function latest_post_shortcode_lps_block_block_init() {
		// Load shortcode related assets.
		wp_enqueue_style(
			'lps-style',
			plugins_url( '../assets/css/style.min.css', __FILE__ ),
			array(),
			LPS_PLUGIN_VERSION,
			false
		);
		wp_register_script(
			'lps-ajax-pagination-js',
			plugins_url( '../assets/js/custom-pagination.min.js', __FILE__ ),
			array( 'jquery' ),
			LPS_PLUGIN_VERSION . LPS_ASSETS_VERSION,
			true
		);
		wp_localize_script(
			'lps-ajax-pagination-js',
			'LPS',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
			)
		);
		wp_enqueue_script( 'lps-ajax-pagination-js' );

		// Load slider related assets.
		wp_enqueue_style(
			'lps-slick-style',
			plugins_url( '../assets/css/slick-custom-theme.min.css', __FILE__ ),
			array(),
			LPS_PLUGIN_VERSION,
			false
		);

		// Slick style from //cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css.
		wp_enqueue_style(
			'lps-slick',
			plugins_url( '../assets/slick-1.8.1/slick.min.css', __FILE__ ),
			array(),
			LPS_PLUGIN_VERSION,
			false
		);

		// Slick js from //cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js.
		wp_enqueue_script(
			'lps-slick',
			plugins_url( '../assets/slick-1.8.1/slick.min.js', __FILE__ ),
			array( 'jquery' ),
			LPS_PLUGIN_VERSION,
			false
		);

		$dir = dirname( __FILE__ );

		$script_asset_path = $dir . '/build/index.asset.php';
		if ( ! file_exists( $script_asset_path ) ) {
			throw new Error(
				'You need to run `npm start` or `npm run build` for the "latest-post-shortcode/lps-block" block first.'
			);
		}
		$index_js     = 'build/index.js';
		$script_asset = require( $script_asset_path );
		wp_register_script(
			'latest-post-shortcode-lps-block-editor',
			plugins_url( $index_js, __FILE__ ),
			$script_asset['dependencies'],
			$script_asset['version']
		);

		$editor_css = 'editor.css';
		wp_register_style(
			'latest-post-shortcode-lps-block-editor',
			plugins_url( $editor_css, __FILE__ ),
			array(),
			filemtime( $dir . '/' . $editor_css )
		);

		$style_css = 'style.css';
		wp_register_style(
			'latest-post-shortcode-lps-block',
			plugins_url( $style_css, __FILE__ ),
			array(),
			filemtime( $dir . '/' . $style_css )
		);

		register_block_type(
			'latest-post-shortcode/lps-block',
			array(
				'editor_script' => 'latest-post-shortcode-lps-block-editor',
				'editor_style'  => 'latest-post-shortcode-lps-block-editor',
				'style'         => 'latest-post-shortcode-lps-block',
				'attributes'    => array(
					'lpsBlockName' => array(
						'type'    => 'string',
						'default' => 'latest-post-shortcode/lps-block',
					),
					'lpsContent'   => array(
						'type'    => 'string',
						'default' => '[latest-selected-content limit="4" display="title" titletag="b" url="yes" image="thumbnail" elements="3" css="four-columns align-left as-overlay tall dark hover-zoom" type="post" status="publish" orderby="dateD"]',
					),
					'postId'    => array(
						'type'    => 'string',
						'default' => '',
					),
					'clientId'  => array(
						'type' => 'string',
					),
					'nthOfType' => array(
						'type' => 'string',
					),
					'className' => array(
						'type'    => 'string',
						'default' => '',
					),
				),
				'supports' => array(
					// 'customClassName' => true,
					'html'            => false,
					'anchor'          => true,
					'align'           => [ 'full', 'wide', 'center' ],
				),
				'render_callback' => 'lps_render_block',
			)
		);
	}
}

if ( ! function_exists( 'lps_add_theme_support' ) ) {
	/**
	 * Add theme support.
	 *
	 * @return void
	 */
	function lps_add_theme_support() {
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'align-wide' );
	}
}

if ( ! function_exists( 'lps_render_block' ) ) {
	/**
	 * Server-side rendering handler.
	 *
	 * @param  array  $block         Block attributes.
	 * @param  string $block_content Block content.
	 * @return string
	 */
	function lps_render_block( $block, $block_content ) {
		if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
			if ( ! empty( $block['lpsBlockName'] ) && 'latest-post-shortcode/lps-block' === $block['lpsBlockName'] ) {
				$post_id    = ( ! empty( $block['postId'] ) ) ? $block['postId'] : 0;
				$client_id  = ( ! empty( $block['clientId'] ) ) ? $block['clientId'] : '';
				$block_ord  = ( ! empty( $block['nthOfType'] ) ) ? (int) $block['nthOfType'] : 0;
				$rendered   = [];
				$collection = [];

				if ( empty( $block_ord ) ) {
					update_post_meta( $post_id, '_lps-block-ids', [] );
				} else {
					$collection = get_post_meta( $post_id, '_lps-block-ids', true );
					if ( ! empty( $collection ) ) {
						foreach ( $collection as $key => $value ) {
							if ( $key === $client_id ) {
								break;
							}
							$rendered = array_merge( $rendered, $value );
						}
						$rendered = array_unique( $rendered );
					}
				}

				global $lps_current_post_embedded_item_ids;
				$lps_current_post_embedded_item_ids = $rendered;

				// Compute here the content.
				$content = do_shortcode( $block['lpsContent'] );

				$collection[ $client_id ] = $lps_current_post_embedded_item_ids;
				update_post_meta( $post_id, '_lps-block-ids', $collection );

				return '<div class="lps-block-preview">' . $content . '</div>';
			}
		}

		$class = ( ! empty( $block['align'] ) ) ? 'align' . $block['align'] : '';
		return '<div class="' . $class . '">' . $block_content . '</div>';
	}
}
