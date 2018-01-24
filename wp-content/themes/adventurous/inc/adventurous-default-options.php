<?php
/**
 * @package Catch Themes
 * @subpackage Adventurous
 * @since Adventurous 1.0
 */

/**
 * Returns the default options for catchadaptive.
 *
 * @since Adventurous Pro 3.9
 */
function adventurous_get_defaults( $parameter = null ) {
	$defaults = array(
		'remove_header_logo'            => '1',
		'featured_logo_header'          => get_template_directory_uri().'/images/logo.png',
		'enable_promotion'              => 'homepage',
		'homepage_headline'             => esc_html__( 'Adventurous is a Simple, Clean and Responsive WordPress Theme', 'adventurous' ),
		'homepage_subheadline'          => esc_html__( 'This is Promotion Headline. You can edit this from "Appearance => Theme Options => Promotion Headline Options"', 'adventurous' ),
		'homepage_headline_button'      => esc_html__( 'Buy Now', 'adventurous' ),
		'homepage_headline_url'         => '#',
		'homepage_headline_target'      => '1',
		'reset_featured_image'          => 0,
		'enable_featured_header_image'  => 'homepage',
		'page_featured_image'           => 'full',
		'featured_header_image_url'     => '',
		'featured_header_image_alt'     => '',
		'featured_header_image_base'    => '0',
		'disable_header_right_sidebar'  => '0',
		'reset_typography'              => 0,
		'custom_css'                    => '',
		'sidebar_layout'                => 'right-sidebar',
		'content_layout'                => 'full',
		'featured_image'                => 'featured',
		'reset_layout'                  => 0,
		'more_tag_text'                 => esc_html__( 'Continue Reading &rarr;', 'adventurous' ),
		'reset_moretag'                 => 0,
		'excerpt_length'                => 30,
		'search_display_text'           => esc_html__( 'Search &hellip;', 'adventurous' ),
		'disable_homepage_headline'     => '0',
		'disable_homepage_subheadline'  => '0',
		'disable_homepage_button'       => '0',
		'enable-featured'               => 'homepage',
		'homepage_featured_headline'    => '',
		'homepage_featured_subheadline' => '',
		'homepage_featured_qty'         => 4,
		'homepage_featured_layout'      => 'four-columns',
		'homepage_featured_image'       => array(),
		'homepage_featured_url'         => array(),
		'homepage_featured_base'        => array(),
		'homepage_featured_title'       => array(),
		'homepage_featured_content'     => array(),
		'enable_posts_home'             => '0',
		'front_page_category'           => '0',
		'select_slider_type'            => 'demo-slider',
		'enable_slider'                 => 'disable-slider',
		'disable_slider_text'           => '1',
		'featured_slider'               => array(),
		'slider_category'               => '0',
		'slider_qty'                    => 4,
		'transition_effect'             => 'fade',
		'transition_delay'              => 4,
		'transition_duration'           => 1,
		'exclude_slider_post'           => '0',
		'disable_scrollup'              => '0',
		'social_facebook'               => '',
		'social_twitter'                => '',
		'social_googleplus'             => '',
		'social_pinterest'              => '',
		'social_youtube'                => '',
		'social_vimeo'                  => '',
		'social_linkedin'               => '',
		'social_slideshare'             => '',
		'social_foursquare'             => '',
		'social_flickr'                 => '',
		'social_tumblr'                 => '',
		'social_deviantart'             => '',
		'social_dribbble'               => '',
		'social_myspace'                => '',
		'social_wordpress'              => '',
		'social_rss'                    => '',
		'social_delicious'              => '',
		'social_lastfm'                 => '',
		'social_instagram'              => '',
		'social_github'                 => '',
		'social_vkontakte'              => '',
		'social_myworld'                => '',
		'social_odnoklassniki'          => '',
		'social_goodreads'              => '',
		'social_skype'                  => '',
		'social_soundcloud'             => '',
		'social_email'                  => '',
		'social_contact'                => '',
		'social_xing'                   => '',
		'social_meetup'                 => '',
		'footer_code'                   => '<div class="copyright">'. esc_attr__( 'Copyright', 'adventurous' ) . ' &copy; ' . adventurous_the_year() . '&nbsp;' . adventurous_site_link() . '&nbsp;' . esc_attr__( 'All Rights Reserved', 'adventurous' ) . '.</div><div class="powered">'. esc_attr__( 'Adventurous Theme by', 'adventurous' ) . '&nbsp;' . adventurous_shop_link() . '</div>',
		'reset_footer'                  => 0
	);

	if ( null !== $parameter ) {
		return $defaults[ $parameter ];
	}
	
	return $defaults;
}


/*
 * Return arrray of theme options merged with default valuse if it does not exist
 */
function adventurous_get_options() {
	return wp_parse_args( ( array ) get_option( 'adventurous_options' ) , adventurous_get_defaults() );
}


/**
 * Returns the current year.
 *
 * @uses date() Gets the current year.
 * @return string
 */
function adventurous_the_year() {
	return date_i18n( esc_html__( 'Y', 'adventurous' ) );
}


/**
 * Returns a link back to the site.
 *
 * @uses get_bloginfo() Gets the site link
 * @return string
 */
function adventurous_site_link() {
	return '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" ><span>' . get_bloginfo( 'name', 'display' ) . '</span></a>';
}


/**
 * Returns a link to Theme Shop.
 *
 * @return string
 */
function adventurous_shop_link() {
	return '<a href="'. esc_url( __( 'https://catchthemes.com', 'adventurous' ) ) . '" target="_blank" title="' . esc_attr__( 'Catch Themes', 'adventurous' ) . '"><span>' . esc_html__( 'Catch Themes', 'adventurous' ) . '</span></a>';
}


/**
 * Returns an array of color schemes registered for adventurous.
 *
 * @since Adventurous 1.6.2
 */
function adventurous_color_schemes() {
	$options = array(
		'light' 		=> esc_html__( 'Light (Blue)', 'adventurous' ),
		'dark'			=> esc_html__( 'Dark', 'adventurous' ),
		'lightblack'	=> esc_html__( 'Light (Black)', 'adventurous' ),
	);

	return apply_filters( 'adventurous_color_schemes', $options );
}


/**
 * Returns an array of featured content layout options
 *
 * @since Adventurous 1.6.2
 */
function adventurous_featured_content_layouts() {
	$options = array(
		'three-columns' => esc_html__( '3 Columns', 'adventurous' ),
		'four-columns'	=> esc_html__( '4 Columns', 'adventurous' ),
	);

	return apply_filters( 'adventurous_featured_content_layouts', $options );
}


/**
 * Returns an array of enable header image options
 *
 * @since Adventurous 1.6.2
 */
function adventurous_enable_header_featured_image() {
	$options = array(
		'homepage' 		=> esc_html__( 'Homepage', 'adventurous' ),
		'excludehome' 	=> esc_html__( 'Excluding Homepage', 'adventurous' ),
		'allpage' 		=> esc_html__( 'Entire Site', 'adventurous' ),
		'postpage' 		=> esc_html__( 'Entire Site, Page/Post Featured Image', 'adventurous' ),
		'pagespostes'	=> esc_html__( 'Pages & Posts', 'adventurous' ),
		'disable'		=> esc_html__( 'Disable', 'adventurous' ),
	);

	return apply_filters( 'adventurous_enable_header_featured_image', $options );
}


/**
 * Returns an array of page/post featured image size
 *
 * @since Adventurous 1.6.2
 */
function adventurous_page_post_featured_image_size() {
	$options = array(
		'full' 		=> esc_html__( 'Full Image', 'adventurous' ),
		'slider' 	=> esc_html__( 'Slider Image', 'adventurous' ),
		'featured'	=> esc_html__( 'Featured Image', 'adventurous' ),
	);

	return apply_filters( 'adventurous_page_post_featured_image_size', $options );
}


/**
 * Returns an array of content featured image size
 *
 * @since Adventurous 1.6.2
 */
function adventurous_content_featured_image_size() {
	$options = array(
		'full' 		=> esc_html__( 'Full Image', 'adventurous' ),
		'slider' 	=> esc_html__( 'Slider Image', 'adventurous' ),
		'featured'	=> esc_html__( 'Featured Image', 'adventurous' ),
		'disable'	=> esc_html__( 'Disable Image', 'adventurous' ),
	);

	return apply_filters( 'adventurous_content_featured_image_size', $options );
}


/**
 * Returns an array of sidebar layout options
 *
 * @since Adventurous 1.6.2
 */
function adventurous_sidebar_layout_options() {
	$options = array(
		'right-sidebar' => esc_html__( 'Right Sidebar', 'adventurous' ),
		'left-sidebar' 	=> esc_html__( 'Left Sidebar', 'adventurous' ),
		'no-sidebar'	=> esc_html__( 'No Sidebar', 'adventurous' ),
	);

	return apply_filters( 'adventurous_sidebar_layout_options', $options );
}


/**
 * Returns an array of slider enable options
 *
 * @since Adventurous 1.6.2
 */
function adventurous_enable_featured_content_options() {
	$options = array(
		'homepage'=> esc_html__( 'Homepage', 'adventurous' ),
		'allpage' => esc_html__( 'Entire Site', 'adventurous' ),
		'disable' => esc_html__( 'Disable', 'adventurous' ),
	);

	return apply_filters( 'adventurous_enable_slider_options', $options );
}


/**
 * Returns an array of content layout options
 *
 * @since Adventurous 1.6.2
 */
function adventurous_content_layout_options() {
	$options = array(
		'full' 		=> esc_html__( 'Full Content Display', 'adventurous' ),
		'excerpt' 	=> esc_html__( 'Excerpt/Blog Display', 'adventurous' ),
	);

	return apply_filters( 'adventurous_content_layout_options', $options );
}


/**
 * Returns an array of slider types
 *
 * @since Adventurous 1.6.2
 */
function adventurous_slider_types() {
	$options = array(
		'demo-slider' 		=> esc_html__( 'Demo Slider', 'adventurous' ),
		'post-slider' 		=> esc_html__( 'Post Slider', 'adventurous' ),
		'category-slider' 	=> esc_html__( 'Category Slider', 'adventurous' ),
	);

	return apply_filters( 'adventurous_slider_types', $options );
}


/**
 * Returns an array of slider enable options
 *
 * @since Adventurous 1.6.2
 */
function adventurous_enable_slider_options() {
	$options = array(
		'enable-slider-homepage'=> esc_html__( 'Homepage', 'adventurous' ),
		'enable-slider-allpage' => esc_html__( 'Entire Site', 'adventurous' ),
		'disable-slider' 		=> esc_html__( 'Disable', 'adventurous' ),
	);

	return apply_filters( 'adventurous_enable_slider_options', $options );
}


/**
 * Returns an array of slider transition effects
 *
 * @since Adventurous 1.6.2
 */
function adventurous_transition_effects() {
	$options = array(
		'fade'			=> esc_html__( 'fade', 'adventurous' ),
		'wipe' 			=> esc_html__( 'wipe', 'adventurous' ),
		'scrollUp' 		=> esc_html__( 'scrollUp', 'adventurous' ),
		'scrollDown'	=> esc_html__( 'scrollDown', 'adventurous' ),
		'scrollUp' 		=> esc_html__( 'scrollUp', 'adventurous' ),
		'scrollLeft'	=> esc_html__( 'scrollLeft', 'adventurous' ),
		'scrollRight'	=> esc_html__( 'scrollRight', 'adventurous' ),
		'blindX' 		=> esc_html__( 'blindX', 'adventurous' ),
		'blindY' 		=> esc_html__( 'blindY', 'adventurous' ),
		'blindZ' 		=> esc_html__( 'blindZ', 'adventurous' ),
		'cover' 		=> esc_html__( 'cover', 'adventurous' ),
		'shuffle' 		=> esc_html__( 'shuffle', 'adventurous' ),
	);

	return apply_filters( 'adventurous_transition_effects', $options );
}