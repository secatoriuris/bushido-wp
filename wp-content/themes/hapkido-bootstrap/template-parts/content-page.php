<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	$enable_vc = get_post_meta(get_the_ID(), '_wpb_vc_js_status', true);
	if(!$enable_vc && !is_front_page()) {
		?>
		
		<?php if (has_post_thumbnail() ) : ?>
			<header class="entry-header height-500">
				<div class="full-width-header height-inherit">
					<div class="row height-inherit" style="direction: rtl;">
						<?php $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>
						<div class="col-sm-12 col-lg-7 height-inherit header-image-container no-padding">
						<img src="<?php echo $backgroundImg[0] ?>">
							
						</div>
						<div class="col-sm-12 col-lg-5 height-inherit" style="background: #191919">
							<div class="title-section">
								<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
								<div class="abstract">
									<?php echo get_post_meta($post->ID, 'abstract', true); ?>
								</div>
							</div>
						</div>	

					</div>		
				</div>
			</header><!-- .entry-header -->
			<?php else: ?> 
				<header class="entry-header">
					<div>
						<?php the_title( '<h1 class="simple-page-entry-title">', '</h1>' ); ?>
					</div>		
				</header><!-- .entry-header -->


			<?php endif; ?>
		</header><!-- .entry-header -->
	<?php } ?>

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wp-bootstrap-starter' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() && !$enable_vc ) : ?>
		<footer class="entry-footer">
			<?php
			edit_post_link(
				sprintf(
					/* translators: %s: Name of current post */
					esc_html__( 'Edit %s', 'wp-bootstrap-starter' ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-## -->
