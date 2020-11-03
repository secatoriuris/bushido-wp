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
			<div class="col-sm-4 footer-col">
				<div class="site-info">
					<div>
						&copy; <?php echo date('Y'); ?> <?php echo '<a href="'.home_url().'">'.get_bloginfo('name').'</a>'; ?>
					</div>
					<div>
						<a href="/impressum">Impressum</a>
						<span class="sep"> | </span>
						<a href="/datenschutz">Datenschutz</a>
					</div>
				</div>
			</div>
			<div class="col-sm-4 footer-col">
				<div class="site-logo">
					<a href="<?php echo esc_url( home_url( '/' )); ?>">
						<img src="<?php echo esc_url(get_theme_mod( 'wp_bootstrap_starter_logo' )); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
					</a>
				</div>
			</div>
			<div class="col-sm-4 footer-col">
				<div class="site-social">
					<div class="social-icon">
						<a href="https://www.facebook.com/pages/Sportschule-Bushido/178230115548262" target="_blank">
							<?php echo '<img src="'.home_url().'/wp-content/themes/bushido-bootstrap/logos/facebook.svg">'?>
						</a>
					</div>
					<div class="social-icon">
						<a href="https://instagram.com/sportschule_bushido?igshid=hfszjde8w1uf" target="_blank">
							<?php echo '<img src="'.home_url().'/wp-content/themes/bushido-bootstrap/logos/instagram.svg">'?>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer><!-- #colophon -->
<?php endif; ?>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>