<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Squareroot
 */

global $squareroot_data;
?>

<footer id="footer" class="page-foot clearfix">
	<div class="container">
		<p class="copyright"><?php if ( isset( $squareroot_data['footer_text'] ) ) {
				echo str_replace( "[Y]", date( "Y" ), $squareroot_data['footer_text'] );
			} ?></p>
		<?php
		if ( is_active_sidebar( 'footer' ) ) {
			dynamic_sidebar( 'footer' );
		}
		?>
	</div>
</footer>

<?php if ( isset( $squareroot_data['totop_show'] ) && $squareroot_data['totop_show'] == 1 ) { ?>
	<a href="javascript:" id="return-to-top" style="display: none;"><i class="fa fa-chevron-up"></i></a>
<?php } ?>

<?php wp_footer(); ?>

</body>
</html>
