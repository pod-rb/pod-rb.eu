<?php
/**
 * The template for displaying search forms in Adventurous
 *
 * @package Catch Themes
 * @subpackage Adventurous
 * @since Adventurous 1.0
 */

// get the data value from theme options
$options = adventurous_get_options();

$adventurous_search_text = $options['search_display_text'];
?>
	<form method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
		<label for="s" class="assistive-text"><?php esc_html_e( 'Search', 'adventurous' ); ?></label>
		<input type="text" class="field" name="s" value="<?php the_search_query(); ?>" id="s" placeholder="<?php echo $adventurous_search_text; ?>" />
		<input type="submit" class="submit" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'adventurous' ); ?>" />
	</form>
