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
	if(!$enable_vc) {
		?>
		
		<?php if (has_post_thumbnail() ) : ?>
			<header class="entry-header height-600">
				<div class="full-width-header height-inherit">
					<div class="row height-inherit">
						<?php $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>
						<div class="col-12 height-inherit header-image-container no-padding"
						style="background: url(<?php echo $backgroundImg[0]?>);
						background-position: center; 
						background-size: cover;
						background-color: #444;
						background-blend-mode: screen;">
						<div class="container header-title">
							<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
						</div>
						<div class="container header-abstract">
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
