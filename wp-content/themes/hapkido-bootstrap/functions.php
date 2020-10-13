<?php 
add_action( 'wp_enqueue_scripts', 'hapkido_enqueue_styles', PHP_INT_MAX );
function hapkido_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' ); 
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'parent-style' ) );
} 

function load_google_fonts() {
	wp_register_style('googleFonts', 'href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap');
	wp_enqueue_style( 'googleFonts');
}
add_action('wp_print_styles', 'load_google_fonts');
add_theme_support( 'responsive-embeds' );

function turn_blogposts_translation_off( $post_types, $is_settings ) {
	unset( $post_types['post'] );

	return $post_types;
}

add_filter( 'pll_get_post_types', 'turn_blogposts_translation_off', 10, 2 );

function custom_render_block_core_latest_posts( $attributes ) {
	$args = array(
		'posts_per_page'   => $attributes['postsToShow'],
		'post_status'      => 'publish',
		'order'            => $attributes['order'],
		'orderby'          => $attributes['orderBy'],
		'suppress_filters' => false,
	);

	add_filter( 'excerpt_length', 20, 20 );

	if ( isset( $attributes['categories'] ) ) {
		$args['category'] = $attributes['categories'];
	}



	$recent_posts = get_posts( $args );

	$list_items_markup = '';

	foreach ( $recent_posts as $post ) {
		$list_items_markup .= '<hr class="news-divider"><li class="lates-news-item"><div class="row">';

		if ( has_post_thumbnail( $post ) ) {
			$image_style = '';
			if ( isset( $attributes['featuredImageSizeWidth'] ) ) {
				$image_style .= sprintf( 'max-width:%spx;', $attributes['featuredImageSizeWidth'] );
			}
			if ( isset( $attributes['featuredImageSizeHeight'] ) ) {
				$image_style .= sprintf( 'max-height:%spx;', $attributes['featuredImageSizeHeight'] );
			}

			$image_classes = 'col-sm-6 col-lg-3 news-image-container';

			$list_items_markup .= sprintf(
				'<div class="%1$s">%2$s</div>',
				$image_classes,
				get_the_post_thumbnail(
					$post,
					$attributes['featuredImageSizeSlug'],
					array(
						'style' => $image_style,
					)
				)
			);
		}

		$title = get_the_title( $post );
		if ( ! $title ) {
			$title = __( '(no title)' );
		}

		$list_items_markup .='<div class="col-sm-6 col-lg-9">';

		$list_items_markup .= sprintf(
			'<time datetime="%1$s" class="wp-block-latest-posts__post-date">%2$s</time>',
			esc_attr( get_the_date( 'c', $post ) ),
			esc_html( get_the_date( '', $post ) )
		);

		$list_items_markup .= sprintf(
			'<p>%1$s</p>',
			$title
		);


// 	if ( isset( $attributes['displayPostContent'] ) && $attributes['displayPostContent']
// 		&& isset( $attributes['displayPostContentRadio'] ) && 'full_post' === $attributes['displayPostContentRadio'] ) {
// 		$list_items_markup .= sprintf(
// 			'<div class="wp-block-latest-posts__post-full-content">%1$s</div>',
// 			wp_kses_post( html_entity_decode( $post->post_content, ENT_QUOTES, get_option( 'blog_charset' ) ) )
// 		);
// }

		$list_items_markup .= sprintf(
			'<div class="wp-block-button"><a class="wp-block-button__link" href="%1$s">Weiterlesen</a></div></div></div></li>',
			esc_url( get_permalink( $post ) )
		);
	}

	remove_filter( 'excerpt_length', 20, 20 );

	$class = 'wp-block-latest-posts wp-block-latest-posts__list';
	if ( isset( $attributes['align'] ) ) {
		$class .= ' align' . $attributes['align'];
	}

	if ( isset( $attributes['postLayout'] ) && 'grid' === $attributes['postLayout'] ) {
		$class .= ' is-grid';
	}

	if ( isset( $attributes['columns'] ) && 'grid' === $attributes['postLayout'] ) {
		$class .= ' columns-' . $attributes['columns'];
	}

	if ( isset( $attributes['displayPostDate'] ) && $attributes['displayPostDate'] ) {
		$class .= ' has-dates';
	}

	if ( isset( $attributes['className'] ) ) {
		$class .= ' ' . $attributes['className'];
	}

	return sprintf(
		'<ul class="%1$s">%2$s</ul>',
		esc_attr( $class ),
		$list_items_markup
	);
}

function custom_register_block_core_latest_posts() {
	register_block_type( 'core/latest-posts', array(
		'render_callback' => 'custom_render_block_core_latest_posts',
	) );
}

add_action( 'init', 'custom_register_block_core_latest_posts',9 );

/**
 * Server-side rendering of the `core/latest-posts` block.
 *
 * @package WordPress
 */

/**
 * The excerpt length set by the Latest Posts core block
 * set at render time and used by the block itself.
 *
 * @var int
 */
$block_core_latest_posts_excerpt_length = 0;

/**
 * Callback for the excerpt_length filter used by
 * the Latest Posts block at render time.
 *
 * @return int Returns the global $block_core_latest_posts_excerpt_length variable
 *             to allow the excerpt_length filter respect the Latest Block setting.
 */


/**
 * Renders the `core/latest-posts` block on server.
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */
function news_render_block_core_latest_posts( $attributes ) {
	global $block_core_latest_posts_excerpt_length;

	$args = array(
		'posts_per_page'   => $attributes['postsToShow'],
		'post_status'      => 'publish',
		'order'            => $attributes['order'],
		'orderby'          => $attributes['orderBy'],
		'suppress_filters' => false,
	);

	$block_core_latest_posts_excerpt_length = $attributes['excerptLength'];
	add_filter( 'excerpt_length', 'block_core_latest_posts_get_excerpt_length', 20 );

	if ( isset( $attributes['categories'] ) ) {
		$args['category'] = $attributes['categories'];
	}

	$recent_posts = get_posts( $args );

	$list_items_markup = '';

	foreach ( $recent_posts as $post ) {
		$list_items_markup .= '<li>';

		if ( $attributes['displayFeaturedImage'] && has_post_thumbnail( $post ) ) {
			$image_style = '';
			if ( isset( $attributes['featuredImageSizeWidth'] ) ) {
				$image_style .= sprintf( 'max-width:%spx;', $attributes['featuredImageSizeWidth'] );
			}
			if ( isset( $attributes['featuredImageSizeHeight'] ) ) {
				$image_style .= sprintf( 'max-height:%spx;', $attributes['featuredImageSizeHeight'] );
			}

			$image_classes = 'wp-block-latest-posts__featured-image';
			if ( isset( $attributes['featuredImageAlign'] ) ) {
				$image_classes .= ' align' . $attributes['featuredImageAlign'];
			}

			$list_items_markup .= sprintf(
				'<div class="%1$s">%2$s</div>',
				$image_classes,
				get_the_post_thumbnail(
					$post,
					$attributes['featuredImageSizeSlug'],
					array(
						'style' => $image_style,
					)
				)
			);
		}

		$title = get_the_title( $post );
		if ( ! $title ) {
			$title = __( '(no title)' );
		}
		$list_items_markup .= sprintf(
			'<a href="%1$s">%2$s</a>',
			esc_url( get_permalink( $post ) ),
			$title
		);

		if ( isset( $attributes['displayPostDate'] ) && $attributes['displayPostDate'] ) {
			$list_items_markup .= sprintf(
				'<time datetime="%1$s" class="wp-block-latest-posts__post-date">%2$s</time>',
				esc_attr( get_the_date( 'c', $post ) ),
				esc_html( get_the_date( '', $post ) )
			);
		}

		if ( isset( $attributes['displayPostContent'] ) && $attributes['displayPostContent']
			&& isset( $attributes['displayPostContentRadio'] ) && 'excerpt' === $attributes['displayPostContentRadio'] ) {

			$trimmed_excerpt = get_the_excerpt( $post );

			$list_items_markup .= sprintf(
				'<div class="wp-block-latest-posts__post-excerpt">%1$s',
				$trimmed_excerpt
			);

			if ( strpos( $trimmed_excerpt, ' &hellip; ' ) !== false ) {
				$list_items_markup .= sprintf(
					'<a href="%1$s">%2$s</a></div>',
					esc_url( get_permalink( $post ) ),
					__( 'Read more' )
				);
			} else {
				$list_items_markup .= sprintf(
					'</div>'
				);
			}
		}

		if ( isset( $attributes['displayPostContent'] ) && $attributes['displayPostContent']
			&& isset( $attributes['displayPostContentRadio'] ) && 'full_post' === $attributes['displayPostContentRadio'] ) {
			$list_items_markup .= sprintf(
				'<div class="wp-block-latest-posts__post-full-content">%1$s</div>',
				wp_kses_post( html_entity_decode( $post->post_content, ENT_QUOTES, get_option( 'blog_charset' ) ) )
			);
		}

		$list_items_markup .= "</li>\n";
	}

	remove_filter( 'excerpt_length', 'block_core_latest_posts_get_excerpt_length', 20 );

	$class = 'wp-block-latest-posts wp-block-latest-posts__list';
	if ( isset( $attributes['align'] ) ) {
		$class .= ' align' . $attributes['align'];
	}

	if ( isset( $attributes['postLayout'] ) && 'grid' === $attributes['postLayout'] ) {
		$class .= ' is-grid';
	}

	if ( isset( $attributes['columns'] ) && 'grid' === $attributes['postLayout'] ) {
		$class .= ' columns-' . $attributes['columns'];
	}

	if ( isset( $attributes['displayPostDate'] ) && $attributes['displayPostDate'] ) {
		$class .= ' has-dates';
	}

	if ( isset( $attributes['className'] ) ) {
		$class .= ' ' . $attributes['className'];
	}

	return sprintf(
		'<ul class="%1$s">%2$s</ul>',
		esc_attr( $class ),
		$list_items_markup
	);
}

/**
 * Registers the `core/latest-posts` block on server.
 */
function news_register_block_core_latest_posts() {
	register_block_type(
		'core/latest-news',
		array(
			'attributes'      => array(
				'align'                   => array(
					'type' => 'string',
					'enum' => array( 'left', 'center', 'right', 'wide', 'full' ),
				),
				'className'               => array(
					'type' => 'string',
				),
				'categories'              => array(
					'type' => 'string',
				),
				'postsToShow'             => array(
					'type'    => 'number',
					'default' => 5,
				),
				'displayPostContent'      => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'displayPostContentRadio' => array(
					'type'    => 'string',
					'default' => 'excerpt',
				),
				'excerptLength'           => array(
					'type'    => 'number',
					'default' => 55,
				),
				'displayPostDate'         => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'postLayout'              => array(
					'type'    => 'string',
					'default' => 'list',
				),
				'columns'                 => array(
					'type'    => 'number',
					'default' => 3,
				),
				'order'                   => array(
					'type'    => 'string',
					'default' => 'desc',
				),
				'orderBy'                 => array(
					'type'    => 'string',
					'default' => 'date',
				),
				'displayFeaturedImage'    => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'featuredImageAlign'      => array(
					'type' => 'string',
					'enum' => array( 'left', 'center', 'right' ),
				),
				'featuredImageSizeSlug'   => array(
					'type'    => 'string',
					'default' => 'thumbnail',
				),
				'featuredImageSizeWidth'  => array(
					'type'    => 'number',
					'default' => null,
				),
				'featuredImageSizeHeight' => array(
					'type'    => 'number',
					'default' => null,
				),
			),
			'render_callback' => 'news_render_block_core_latest_posts',
		)
	);
}
add_action( 'init', 'news_register_block_core_latest_posts' );

?>
