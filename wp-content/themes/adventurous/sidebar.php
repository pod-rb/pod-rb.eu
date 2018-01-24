<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Catch Themes
 * @subpackage Adventurous
 * @since Adventurous 1.0
 */
?>

<?php
/**
 * adventurous_above_secondary hook
 */
do_action( 'adventurous_before_secondary' );

$adventurous_layout = adventurous_get_theme_layout();

if ( !is_active_sidebar( 'adventurous_woocommerce_sidebar' ) && ( class_exists( 'Woocommerce' ) && is_woocommerce() ) ) {
	$adventurous_layout = 'no-sidebar';
}

if ( 'left-sidebar' == $adventurous_layout || 'right-sidebar' == $adventurous_layout ) {
	//Getting Ready to load data from Theme Options Panel
	global $post, $wp_query;

	// Front page displays in Reading Settings
	$page_on_front = get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts');

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();

	// Post /Page /General Layout
	if ( $post) {
		if ( is_attachment() ) {
			$sidebaroptions = get_post_meta( $parent, 'adventurous-sidebar-options', true );

		} else {
			$sidebaroptions = get_post_meta( $post->ID, 'adventurous-sidebar-options', true );
		}
	}
	else {
		$sidebaroptions = '';
	}

	?>
	<div id="secondary" class="widget-area" role="complementary">
		<?php
		/**
		 * adventurous_before_widget_start hook
		 */
		do_action( 'adventurous_before_widget_start' );

		if ( is_active_sidebar( 'sidebar-1' ) ) {
        	dynamic_sidebar( 'sidebar-1' );
   		}
		else { ?>
			<aside id="search" class="widget widget_search">
				<?php get_search_form(); ?>
			</aside>

			<aside id="archives" class="widget">
				<h3 class="widget-title"><?php _e( 'Archives', 'adventurous' ); ?></h3>
				<ul>
					<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
				</ul>
			</aside>

		<?php
		} // end sidebar widget area ?>

		<?php
		/**
		 * adventurous_after_widget_ends hook
		 */
		do_action( 'adventurous_after_widget_ends' ); ?>
	</div><!-- #secondary .widget-area -->
	<?php
	}

/**
 * adventurous_after_secondary hook
 */
do_action( 'adventurous_after_secondary' );