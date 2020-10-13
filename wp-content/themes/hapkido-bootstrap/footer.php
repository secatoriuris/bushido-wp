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
		<h2 class="h2-footer">Unser Sponsor</h2>
		<hr class="footer-divider"/>

		<div class="row">
			<div class="offset-1 col-10 offset-sm-2 col-sm-8 offset-lg-3 col-lg-6 center-align">
				<?php echo '<img class="width-70" src="'.home_url().'/wp-content/themes/hapkido-bootstrap/logos/seifert.png">'?>
			</div>

		</div>
		<h2 class="h2-footer">Unsere Partner</h2>
		<hr class="footer-divider"/>
		<div class="row">
			<div class="offset-3 col-6 offset-sm-0 col-sm-4 offset-lg-1 col-lg-2 center-align">
				<a href="https://www.phoenix-budo.de/" class="footer-sponsor-secondary">
					<?php echo '<img class="width-70" src="'.home_url().'/wp-content/themes/hapkido-bootstrap/logos/phoenix.png">'?>				
				</a>
			</div>
			<div class="offset-3 col-6 offset-sm-0 col-sm-4 offset-lg-2 col-lg-2 center-align">
				<a href="https://www.phantom-athletics.com/">
					<?php echo '<img class="width-70" 
								style="max-height: 70%; padding-left: 15%; margin-top: 15%;" 
								src="'.home_url().'/wp-content/themes/hapkido-bootstrap/logos/phantom.png">'?>				
				</a>
			</div>
			<div class="offset-3 col-6 offset-sm-0 col-sm-4 offset-lg-2 col-lg-2 center-align">
				<a href="http://excom-berlin.de/" class="footer-sponsor-secondary">
					<?php echo '<img class="width-70" src="'.home_url().'/wp-content/themes/hapkido-bootstrap/logos/excom.png">'?>
				</a>
			</div>
		</div>
		<div class="footer-background">
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
				<div class="col-sm-4">
					<div class="site-logo">
						<?php echo '<img src="'.home_url().'/wp-content/themes/hapkido-bootstrap/logos/hkdb-logo.png">'?>
					</div>
				</div>
				<div class="col-sm-4 footer-col">
					<div class="site-social">
						<div class="social-icon">
							<a href="https://www.instagram.com/hapkido_team_berlin/?hl=de" target="_blank">
								<?php echo '<img src="'.home_url().'/wp-content/themes/hapkido-bootstrap/logos/instagram.svg">'?>
							</a>
						</div>
						<div class="social-icon">
							<a href="https://www.facebook.com/HapkidoTeamBerlin" target="_blank">
								<?php echo '<img src="'.home_url().'/wp-content/themes/hapkido-bootstrap/logos/facebook.svg">'?>
							</a>
						</div>
						<div class="social-icon">
							<a href="https://www.youtube.com/channel/UCJsPt5jShcUZLZZGDAnHAmA" target="_blank">
								<?php echo '<img src="'.home_url().'/wp-content/themes/hapkido-bootstrap/logos/youtube.svg">'?>
							</a>
						</div>
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