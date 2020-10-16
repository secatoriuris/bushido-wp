<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Bootstrap_Starter
 */

?>
<?php if(!is_page_template( 'blank-page.php' ) && !is_page_template( 'blank-page-with-container.php' )): ?>
</div><!-- .row -->
</div><!-- .container -->
</div><!-- #content -->
<?php get_template_part( 'footer-widget' ); ?>
<footer id="colophon" class="site-footer <?php echo wp_bootstrap_starter_bg_class(); ?>" role="contentinfo">
	<div class="container pt-3 pb-3">
		<div class="row">
			<div class="col-sm-8 col-md-9 footer-col site-info">
				<div>
					&copy; <?php echo date('Y'); ?> <?php echo get_bloginfo('name'); ?>
				</div>
				<div>
					<a href="/impressum">Impressum</a>
					<span class="sep"> | </span>
					<a href="/datenschutz">Datenschutz</a>
				</div>
			</div>
			<div class="col-sm-2 footer-col site-logo">
				<a href="<?php echo esc_url( home_url( '/' )); ?>">
					<img src="<?php echo esc_url(get_theme_mod( 'wp_bootstrap_starter_logo' )); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
				</a>
			</div>
		</div>
	</div>
</footer><!-- #colophon -->
<?php endif; ?>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>