<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Catch Themes
 * @subpackage Adventurous
 * @since Adventurous 1.0
 */

/**
 * Enqueue scripts and styles
 */
function adventurous_scripts() {

	global $wp_query;
	// Getting data from Theme Options
	$options = adventurous_get_options();;

	// Front page displays in Reading Settings
	$page_for_posts = get_option('page_for_posts');

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();

	/**
	 * Loads up main stylesheet.
	 */
	wp_enqueue_style( 'adventurous-style', get_stylesheet_uri() );

	// Add Genericons font, used in the main stylesheet.
	wp_enqueue_style( 'genericons', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'css/genericons/genericons.css', false, '3.4.1' );

	/**
	 * Loads up Responsive stylesheet
	 */
	wp_enqueue_style( 'adventurous-responsive', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'css/responsive.css' );

	/**
	 * Loads up Responsive Video Script
	 */
	wp_enqueue_script( 'jquery-fitvids', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/fitvids.min.js', array( 'jquery' ), '20140317', true );

	/**
	 * Loads up jQuery Custom Scripts
	 */
	wp_enqueue_script( 'adventurous-custom', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/adventurous-custom.min.js', array( 'jquery' ), '20150601', true );

	/**
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'keyboard-image-navigation', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}

	/**
	 * Register JQuery circle all and JQuery set up as dependent on Jquery-cycle
	 */
	wp_register_script( 'jquery-cycle', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/jquery.cycle.all.min.js', array( 'jquery' ), '20140317', true );

	/**
	 * Loads up adventurous-slider and jquery-cycle set up as dependent on adventurous-slider
	 */
	$enableslider = $options['enable_slider'];

	if ( ( 'enable-slider-allpage' == $enableslider ) || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'enable-slider-homepage' == $enableslider ) ) {
		wp_enqueue_script( 'adventurous-slider', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/adventurous-slider.js', array( 'jquery-cycle' ), '20140317', true );
	}

	// Load the html5 shiv.
	wp_enqueue_script( 'adventurous-html5', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/html5.min.js', array(), '3.7.3' );
	wp_style_add_data( 'adventurous-html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'selectivizr', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/selectivizr.min.js', array( 'jquery' ), '20130114', false );
	wp_style_add_data( 'selectivizr', 'conditional', 'lt IE 9' );

	wp_enqueue_style( 'adventurous-iecss', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'css/ie.css' );
	wp_style_add_data( 'adventurous-iecss', 'conditional', 'lt IE 9' );
}
add_action( 'wp_enqueue_scripts', 'adventurous_scripts' );


/**
 * Responsive Layout
 *
 * @get the data value of responsive layout from theme options
 * @display responsive meta tag
 * @action wp_head
 */
function adventurous_responsive() {
	echo '<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">';
} // adventurous_responsive
add_filter( 'wp_head', 'adventurous_responsive', 1 );


if ( ! function_exists( 'adventurous_content_image' ) ) :
/**
 * Template for Featured Image in Content
 *
 * To override this in a child theme
 * simply create your own adventurous_content_image(), and that function will be used instead.
 *
 * @since Adventurous 1.0
 */
function adventurous_content_image() {
	global $post, $wp_query;

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();

	if ( $post) {
 		if ( is_attachment() ) {
			$parent = $post->post_parent;
			$individual_featured_image = get_post_meta( $parent,'adventurous-featured-image', true );
		} else {
			$individual_featured_image = get_post_meta( $page_id,'adventurous-featured-image', true );
		}
	}

	if ( empty( $individual_featured_image ) || ( !is_page() && !is_single() ) ) {
		$individual_featured_image='default';
	}

	// Getting data from Theme Options
	$options = adventurous_get_options();

	$featured_image = $options['featured_image'];

	if ( ( 'disable' == $individual_featured_image || '' == get_the_post_thumbnail() || ( $individual_featured_image=='default' && 'disable' == $featured_image) ) ) {
		return false;
	}
	else { ?>
		<figure class="featured-image">
            <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'adventurous' ), the_title_attribute( 'echo=0' ) ) ); ?>">
                <?php
				if ( ( is_front_page() && 'featured' == $featured_image ) ||  'featured' == $individual_featured_image || ( $individual_featured_image=='default' && 'featured' == $featured_image ) ) {
                     the_post_thumbnail( 'featured' );
                }
				elseif ( ( is_front_page() && 'slider' == $featured_image ) || 'slider' == $individual_featured_image || ( $individual_featured_image=='default' && 'slider' == $featured_image ) ) {
					the_post_thumbnail( 'slider' );
				}
				else {
					the_post_thumbnail( 'full' );
				} ?>
			</a>
        </figure>
   	<?php
	}
}
endif; //adventurous_content_image


/**
 * Hooks the Custom Inline CSS to head section
 *
 * @since Adventurous 1.0
 * @remove when WordPress version 5.0 is released
 */
function adventurous_inline_css() {
	/**
	 * Bail if WP version >=4.7 as we have migrated this option to core
	 */
	if ( function_exists( 'wp_update_custom_css_post' ) ) {
		return;
	}

	//delete_transient( 'adventurous_inline_css' );

	if ( ( !$output = get_transient( 'adventurous_inline_css' ) ) ) {
		$options = adventurous_get_options();

		if ( !empty( $options['custom_css'] ) )  {

			$output	.= '<!-- '.get_bloginfo('name').' Custom CSS Styles -->' . "\n";
	        $output .= '<style type="text/css" media="screen">' . "\n";
			$output .=  $options['custom_css'] . "\n";
			$output .= '</style>' . "\n";

		}

		set_transient( 'adventurous_inline_css', $output, 86940 );
	}

	echo $output;
}
add_action('wp_head', 'adventurous_inline_css');


/**
 * Sets the post excerpt length to 30 words.
 *
 * function tied to the excerpt_length filter hook.
 * @uses filter excerpt_length
 */
function adventurous_excerpt_length( $length ) {
	// Getting data from Theme Options
	$options = adventurous_get_options();

	return $options['excerpt_length'];
}
add_filter( 'excerpt_length', 'adventurous_excerpt_length' );


/**
 * Returns a "Continue Reading" link for excerpts
 */
function adventurous_continue_reading() {
	// Getting data from Theme Options
	$options = adventurous_get_options();

	$more_tag_text = $options['more_tag_text'];
	return ' <a class="more-link" href="'. esc_url( get_permalink() ) . '">' .  $more_tag_text . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with adventurous_continue_reading().
 *
 */
function adventurous_excerpt_more( $more ) {
	return adventurous_continue_reading();
}
add_filter( 'excerpt_more', 'adventurous_excerpt_more' );


/**
 * Adds Continue Reading link to post excerpts.
 *
 * function tied to the get_the_excerpt filter hook.
 */
function adventurous_custom_excerpt( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= adventurous_continue_reading();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'adventurous_custom_excerpt' );


/**
 * Replacing Continue Reading link to the_content more.
 *
 * function tied to the the_content_more_link filter hook.
 */
function adventurous_more_link( $more_link, $more_link_text ) {
	// Getting data from Theme Options
	$options = adventurous_get_options();

	$more_tag_text = $options['more_tag_text'];

	return str_replace( $more_link_text, $more_tag_text, $more_link );
}
add_filter( 'the_content_more_link', 'adventurous_more_link', 10, 2 );


/**
 * Adds custom classes to the array of body classes.
 *
 * @since Adventurous 1.0
 */
function adventurous_body_classes( $classes ) {
	$options = adventurous_get_options();

	if ( ( class_exists( 'Woocommerce' ) && is_woocommerce() ) &&  !is_active_sidebar( 'adventurous_woocommerce_sidebar' ) ) {
		$classes[] = 'woocommerce-nosidebar';
	}

	if ( is_page_template( 'page-blog.php') ) {
		$classes[] = 'page-blog';
	}

	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	$classes[] = adventurous_get_theme_layout();

	$current_content_layout = $options['content_layout'];
	if ( 'full' == $current_content_layout ) {
		$classes[] = 'content-full';
	}
	elseif ( 'excerpt' == $current_content_layout ) {
		$classes[] = 'content-excerpt';
	}

	return $classes;
}
add_filter( 'body_class', 'adventurous_body_classes' );


/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 *
 * @since Adventurous 1.0
 */
function adventurous_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;
}
add_filter( 'attachment_link', 'adventurous_enhanced_image_navigation', 10, 2 );


/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @since Adventurous 1.0
 */
function adventurous_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'adventurous_page_menu_args' );


/**
 * Removes div from wp_page_menu() and replace with ul.
 *
 * @since Adventurous 1.0
 */
function adventurous_wp_page_menu ($page_markup) {
    preg_match('/^<div class=\"([a-z0-9-_]+)\">/i', $page_markup, $matches);
        $divclass = $matches[1];
        $replace = array('<div class="'.$divclass.'">', '</div>');
        $new_markup = str_replace($replace, '', $page_markup);
        $new_markup = preg_replace('/^<ul>/i', '<ul class="'.$divclass.'">', $new_markup);
        return $new_markup; }

add_filter( 'wp_page_menu', 'adventurous_wp_page_menu' );


if ( ! function_exists( 'adventurous_main_wrapper' ) ) :
/**
 * Open Div ID main
 *
 */
function adventurous_main_wrapper() {
	echo '<div id="main">';
}
endif; // adventurous_main_wrapper


if ( ! function_exists( 'adventurous_main_wrapper_close' ) ) :
/**
 * Close Div ID main
 *
 */
function adventurous_main_wrapper_close() {
	echo '</div><!-- #main -->';
}
endif; // adventurous_main_wrapper_close



if ( ! function_exists( 'adventurous_content_sidebar_wrapper' ) ) :
/**
 * Open Div ID content-sidebar
 *
 */
function adventurous_content_sidebar_wrapper() {
	echo '<div id="content-sidebar" class="container">';
}
endif; // adventurous_content_sidebar_wrapper


if ( ! function_exists( 'adventurous_content_sidebar_wrapper_close' ) ) :
/**
 * Close Div ID content-sidebar
 *
 */
function adventurous_content_sidebar_wrapper_close() {
	echo '</div><!-- #content-sidebar -->';
}
endif; // adventurous_content_sidebar_wrapper_close


if ( ! function_exists( 'content_sidebar_check' ) ) :
/**
 * Cheking in Condition for main Wrap
 *
 */
function content_sidebar_check() {
	global $wp_query;
	// Getting data from Theme Options
	$options     = adventurous_get_options();
	$enable_post = $options['enable_posts_home'];

	// Front page displays in Reading Settings
	$page_on_front = get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts');

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();

	if ( is_front_page() && is_home() && !empty( $enable_post ) ) {
		return;
	}
	elseif ( is_front_page() ) {
		add_action( 'adventurous_main', 'adventurous_main_wrapper', 10 );
		add_action( 'adventurous_content_sidebar', 'adventurous_content_sidebar_wrapper', 10 );
		add_action( 'adventurous_content_sidebar_close', 'adventurous_content_sidebar_wrapper_close', 10 );
		add_action( 'adventurous_main_close', 'adventurous_main_wrapper_close', 10 );
	}
	elseif ( is_home() && !empty( $enable_post ) && empty( $page_id ) ) {
		return;
	}
	else {
		add_action( 'adventurous_main', 'adventurous_main_wrapper', 10 );
		add_action( 'adventurous_content_sidebar', 'adventurous_content_sidebar_wrapper', 10 );
		add_action( 'adventurous_content_sidebar_close', 'adventurous_content_sidebar_wrapper_close', 10 );
		add_action( 'adventurous_main_close', 'adventurous_main_wrapper_close', 10 );
	}
}
endif; // content_sidebar_check

add_action( 'adventurous_before_main', 'content_sidebar_check', 20 );


/**
 * Footer Sidebar
 *
 * @Hooked in adventurous_footer
 * @since Adventurous 1.0
 */
function adventurous_footer_sidebar() {
	get_sidebar( 'footer' );
}
add_action( 'adventurous_footer', 'adventurous_footer_sidebar', 10 );


/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 */
function adventurous_footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'sidebar-2' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-3' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-4' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-5' ) )
		$count++;

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'one container';
			break;
		case '2':
			$class = 'two container';
			break;
		case '3':
			$class = 'three container';
			break;
		case '4':
			$class = 'four container';
			break;
	}

	if ( $class )
		echo 'class="' . $class . '"';
}


/**
 * Footer Site Generator Open
 *
 * @Hooked in adventurous_site_generator
 * @since Adventurous 1.0
 */
function adventurous_site_generator_open() {
	echo '<div id="site-generator"><div class="site-info container">';
}
add_action( 'adventurous_site_generator', 'adventurous_site_generator_open', 10 );


/**
 * Footer Site Generator Close
 *
 * @Hooked in adventurous_site_generator
 * @since Adventurous 1.0
 */
function adventurous_site_generator_close() {
	echo '</div><!-- .site-info container --></div><!-- #site-generator -->';
}
add_action( 'adventurous_site_generator', 'adventurous_site_generator_close', 100 );


if ( ! function_exists( 'adventurous_footer_content' ) ) :
/**
 * Template for Footer Content
 *
 * To override this in a child theme
 * simply create your own adventurous_footer_content(), and that function will be used instead.
 *
 * @uses adventurous_site_generator action to add it in the footer
 * @since Adventurous 1.0
 */
function adventurous_footer_content() {
	//delete_transient( 'adventurous_footer_content' );

	if ( ( !$adventurous_footer_content = get_transient( 'adventurous_footer_content' ) ) ) {
		echo '<!-- refreshing cache -->';

		// get the data value from theme options
		$options = adventurous_get_options();

		$adventurous_footer_content = $options['footer_code'];

    	set_transient( 'adventurous_footer_content', $adventurous_footer_content, 86940 );
    }
	echo $adventurous_footer_content;
}
endif;
add_action( 'adventurous_site_generator', 'adventurous_footer_content', 20 );


/**
 * Alter the query for the main loop in homepage
 * @uses pre_get_posts hook
 */
function adventurous_alter_home( $query ){
	if ( $query->is_main_query() && $query->is_home() ) {
		$options = adventurous_get_options();

	    $cats = $options['front_page_category'];

	    if ( '0' != $options[ 'exclude_slider_post'] && !empty( $options['featured_slider'] ) ) {
			$query->query_vars['post__not_in'] = $options['featured_slider'];
		}

		if ( is_array( $cats ) && !in_array( '0', $cats ) ) {
			$query->query_vars['category__in'] = $cats;
		}
	}
}
add_action( 'pre_get_posts','adventurous_alter_home' );


if ( ! function_exists( 'adventurous_social_networks' ) ) :
/**
 * Template for Social Icons
 *
 * To override this in a child theme
 * simply create your own adventurous_social_networks(), and that function will be used instead.
 *
 * @since Adventurous 1.0
 */
function adventurous_social_networks() {
	//delete_transient( 'adventurous_social_networks' );

	// get the data value from theme options
	$options = adventurous_get_options();

    $elements = array();

	$elements = array( 	$options['social_facebook'],
						$options['social_twitter'],
						$options['social_googleplus'],
						$options['social_linkedin'],
						$options['social_pinterest'],
						$options['social_youtube'],
						$options['social_vimeo'],
						$options['social_slideshare'],
						$options['social_foursquare'],
						$options['social_flickr'],
						$options['social_tumblr'],
						$options['social_deviantart'],
						$options['social_dribbble'],
						$options['social_myspace'],
						$options['social_wordpress'],
						$options['social_rss'],
						$options['social_delicious'],
						$options['social_lastfm'],
						$options['social_instagram'],
						$options['social_github'],
						$options['social_vkontakte'],
						$options['social_myworld'],
						$options['social_odnoklassniki'],
						$options['social_goodreads'],
						$options['social_skype'],
						$options['social_soundcloud'],
						$options['social_email'],
						$options['social_contact'],
						$options['social_xing'],
						$options['social_meetup']
					);
	$flag = 0;
	if ( !empty( $elements ) ) {
		foreach( $elements as $option) {
			if ( !empty( $option ) ) {
				$flag = 1;
			}
			else {
				$flag = 0;
			}
			if ( $flag == 1 ) {
				break;
			}
		}
	}

	if ( ( !$adventurous_social_networks = get_transient( 'adventurous_social_networks' ) ) && ( $flag == 1 || !empty ( $options['social_custom_image'] ) ) )  {
		echo '<!-- refreshing cache -->';

		$adventurous_social_networks .='
		<ul class="social-profile">';
			//facebook
			if ( !empty( $options['social_facebook'] ) ) {
				$adventurous_social_networks .=
					'<li class="facebook"><a href="'.esc_url( $options['social_facebook'] ).'" title="'. esc_attr__( 'Facebook', 'adventurous' ) .'" target="_blank">'. esc_attr__( 'Facebook', 'adventurous' ) .'</a></li>';
			}
			//Twitter
			if ( !empty( $options['social_twitter'] ) ) {
				$adventurous_social_networks .=
					'<li class="twitter"><a href="'.esc_url( $options['social_twitter'] ).'" title="'. esc_attr__( 'Twitter', 'adventurous' ) .'" target="_blank">'. esc_attr__( 'Twitter', 'adventurous' ) .'</a></li>';
			}
			//Google+
			if ( !empty( $options['social_googleplus'] ) ) {
				$adventurous_social_networks .=
					'<li class="google-plus"><a href="'.esc_url( $options['social_googleplus'] ).'" title="'. esc_attr__( 'Google+', 'adventurous' ) .'" target="_blank">'. esc_attr__( 'Google+', 'adventurous' ) .'</a></li>';
			}
			//Linkedin
			if ( !empty( $options['social_linkedin'] ) ) {
				$adventurous_social_networks .=
					'<li class="linkedin"><a href="'.esc_url( $options['social_linkedin'] ).'" title="'. esc_attr__( 'LinkedIn', 'adventurous' ) .'" target="_blank">'. esc_attr__( 'LinkedIn', 'adventurous' ) .'</a></li>';
			}
			//Pinterest
			if ( !empty( $options['social_pinterest'] ) ) {
				$adventurous_social_networks .=
					'<li class="pinterest"><a href="'.esc_url( $options['social_pinterest'] ).'" title="'. esc_attr__( 'Pinterest', 'adventurous' ) .'" target="_blank">'. esc_attr__( 'Pinterest', 'adventurous' ) .'</a></li>';
			}
			//Youtube
			if ( !empty( $options['social_youtube'] ) ) {
				$adventurous_social_networks .=
					'<li class="you-tube"><a href="'.esc_url( $options['social_youtube'] ).'" title="'. esc_attr__( 'YouTube', 'adventurous' ) .'" target="_blank">'. esc_attr__( 'YouTube', 'adventurous' ) .'</a></li>';
			}
			//Vimeo
			if ( !empty( $options['social_vimeo'] ) ) {
				$adventurous_social_networks .=
					'<li class="viemo"><a href="'.esc_url( $options['social_vimeo'] ).'" title="'. esc_attr__( 'Vimeo', 'adventurous' ) .'" target="_blank">'. esc_attr__( 'Vimeo', 'adventurous' ) .'</a></li>';
			}
			//Slideshare
			if ( !empty( $options['social_slideshare'] ) ) {
				$adventurous_social_networks .=
					'<li class="slideshare"><a href="'.esc_url( $options['social_slideshare'] ).'" title="'. esc_attr__( 'SlideShare', 'adventurous' ) .'" target="_blank">'. esc_attr__( 'SlideShare', 'adventurous' ) .'</a></li>';
			}
			//Foursquare
			if ( !empty( $options['social_foursquare'] ) ) {
				$adventurous_social_networks .=
					'<li class="foursquare"><a href="'.esc_url( $options['social_foursquare'] ).'" title="'. esc_attr__( 'FourSquare', 'adventurous' ) .'" target="_blank">'. esc_attr__( 'FourSquare', 'adventurous' ) .'</a></li>';
			}
			//Flickr
			if ( !empty( $options['social_flickr'] ) ) {
				$adventurous_social_networks .=
					'<li class="flickr"><a href="'.esc_url( $options['social_flickr'] ).'" title="'. esc_attr__( 'Flickr', 'adventurous' ) .'" target="_blank">'. esc_attr__( 'Flickr', 'adventurous' ) .'</a></li>';
			}
			//Tumblr
			if ( !empty( $options['social_tumblr'] ) ) {
				$adventurous_social_networks .=
					'<li class="tumblr"><a href="'.esc_url( $options['social_tumblr'] ).'" title="'. esc_attr__( 'Tumblr', 'adventurous' ) .'" target="_blank">'. esc_attr__( 'Tumblr', 'adventurous' ) .'</a></li>';
			}
			//deviantART
			if ( !empty( $options['social_deviantart'] ) ) {
				$adventurous_social_networks .=
					'<li class="deviantart"><a href="'.esc_url( $options['social_deviantart'] ).'" title="'. esc_attr__( 'deviantART', 'adventurous' ) .'" target="_blank">'. esc_attr__( 'deviantART', 'adventurous' ) .'</a></li>';
			}
			//Dribbble
			if ( !empty( $options['social_dribbble'] ) ) {
				$adventurous_social_networks .=
					'<li class="dribbble"><a href="'.esc_url( $options['social_dribbble'] ).'" title="'. esc_attr__( 'Dribbble', 'adventurous' ) .'" target="_blank">'. esc_attr__( 'Dribbble', 'adventurous' ) .'</a></li>';
			}
			//MySpace
			if ( !empty( $options['social_myspace'] ) ) {
				$adventurous_social_networks .=
					'<li class="myspace"><a href="'.esc_url( $options['social_myspace'] ).'" title="'. esc_attr__( 'MySpace', 'adventurous' ) .'" target="_blank">'. esc_attr__( 'MySpace', 'adventurous' ) .'</a></li>';
			}
			//WordPress
			if ( !empty( $options['social_wordpress'] ) ) {
				$adventurous_social_networks .=
					'<li class="wordpress"><a href="'.esc_url( $options['social_wordpress'] ).'" title="'. esc_attr__( 'WordPress', 'adventurous' ) .'" target="_blank">'. esc_attr__( 'WordPress', 'adventurous' ) .'</a></li>';
			}
			//RSS
			if ( !empty( $options['social_rss'] ) ) {
				$adventurous_social_networks .=
					'<li class="rss"><a href="'.esc_url( $options['social_rss'] ).'" title="'. esc_attr__( 'RSS', 'adventurous' ) .'" target="_blank">'. esc_attr__( 'RSS', 'adventurous' ) .'</a></li>';
			}
			//Delicious
			if ( !empty( $options['social_delicious'] ) ) {
				$adventurous_social_networks .=
					'<li class="delicious"><a href="'.esc_url( $options['social_delicious'] ).'" title="'. esc_attr__( 'Delicious', 'adventurous' ) .'" target="_blank">'. esc_attr__( 'Delicious', 'adventurous' ) .'</a></li>';
			}
			//Last.fm
			if ( !empty( $options['social_lastfm'] ) ) {
				$adventurous_social_networks .=
					'<li class="lastfm"><a href="'.esc_url( $options['social_lastfm'] ).'" title="'. esc_attr__( 'Last.fm', 'adventurous' ) .'" target="_blank">'. esc_attr__( 'Last.fm', 'adventurous' ) .'</a></li>';
			}
			//Instagram
			if ( !empty( $options['social_instagram'] ) ) {
				$adventurous_social_networks .=
					'<li class="instagram"><a href="'.esc_url( $options['social_instagram'] ).'" title="'. esc_attr__( 'Instagram', 'adventurous' ) .'" target="_blank">'. esc_attr__( 'Instagram', 'adventurous' ) .'</a></li>';
			}
			//GitHub
			if ( !empty( $options['social_github'] ) ) {
				$adventurous_social_networks .=
					'<li class="github"><a href="'.esc_url( $options['social_github'] ).'" title="'. esc_attr__( 'GitHub', 'adventurous' ) .'" target="_blank">'. esc_attr__( 'GitHub', 'adventurous' ) .'</a></li>';
			}
			//Vkontakte
			if ( !empty( $options['social_vkontakte'] ) ) {
				$adventurous_social_networks .=
					'<li class="vkontakte"><a href="'.esc_url( $options['social_vkontakte'] ).'" title="'. esc_attr__( 'Vkontakte', 'adventurous' ) .'" target="_blank">'. esc_attr__( 'Vkontakte', 'adventurous' ) .'</a></li>';
			}
			//My World
			if ( !empty( $options['social_myworld'] ) ) {
				$adventurous_social_networks .=
					'<li class="myworld"><a href="'.esc_url( $options['social_myworld'] ).'" title="'. esc_attr__( 'My World', 'adventurous' ) .'" target="_blank">'. esc_attr__( 'My World', 'adventurous' ) .'</a></li>';
			}
			//Odnoklassniki
			if ( !empty( $options['social_odnoklassniki'] ) ) {
				$adventurous_social_networks .=
					'<li class="odnoklassniki"><a href="'.esc_url( $options['social_odnoklassniki'] ).'" title="'. esc_attr__( 'Odnoklassniki', 'adventurous' ) .'" target="_blank">'. esc_attr__( 'Odnoklassniki', 'adventurous' ) .'</a></li>';
			}
			//Goodreads
			if ( !empty( $options['social_goodreads'] ) ) {
				$adventurous_social_networks .=
					'<li class="goodreads"><a href="'.esc_url( $options['social_goodreads'] ).'" title="'. esc_attr__( 'GoodReads', 'adventurous' ) .'" target="_blank">'. esc_attr__( 'GoodReads', 'adventurous' ) .'</a></li>';
			}
			//Skype
			if ( !empty( $options['social_skype'] ) ) {
				$adventurous_social_networks .=
					'<li class="skype"><a href="'.esc_attr( $options['social_skype'] ).'" title="'. esc_attr__( 'Skype', 'adventurous' ) .'" target="_blank">'. esc_attr__( 'Skype', 'adventurous' ) .'</a></li>';
			}
			//Soundcloud
			if ( !empty( $options['social_soundcloud'] ) ) {
				$adventurous_social_networks .=
					'<li class="soundcloud"><a href="'.esc_url( $options['social_soundcloud'] ).'" title="'. esc_attr__( 'SoundCloud', 'adventurous' ) .'" target="_blank">'. esc_attr__( 'SoundCloud', 'adventurous' ) .'</a></li>';
			}
			//Email
			if ( !empty( $options['social_email'] ) ) {
				$adventurous_social_networks .=
					'<li class="email"><a href="mailto:'.sanitize_email( $options['social_email'] ).'" title="'. esc_attr__( 'Email', 'adventurous' ) .'" target="_blank">'. esc_attr__( 'Email', 'adventurous' ) .'</a></li>';
			}
			//Contact
			if ( !empty( $options['social_contact'] ) ) {
				$adventurous_social_networks .=
					'<li class="contactus"><a href="'.esc_url( $options['social_contact'] ).'" title="'. esc_attr__( 'Contact', 'adventurous' ) .'">'. esc_attr__( 'Contact', 'adventurous' ) .'</a></li>';
			}
			//Xing
			if ( !empty( $options['social_xing'] ) ) {
				$adventurous_social_networks .=
					'<li class="xing"><a href="'.esc_url( $options['social_xing'] ).'" title="'. esc_attr__( 'Xing', 'adventurous' ) .'" target="_blank">'. esc_attr__( 'Xing', 'adventurous' ) .'</a></li>';
			}
			//Meetup
			if ( !empty( $options['social_meetup'] ) ) {
				$adventurous_social_networks .=
					'<li class="meetup"><a href="'.esc_url( $options['social_meetup'] ).'" title="'. esc_attr__( 'Meetup', 'adventurous' ) .'" target="_blank">'. esc_attr__( 'Meetup', 'adventurous' ) .'</a></li>';
			}

			$adventurous_social_networks .='
		</ul>';

		set_transient( 'adventurous_social_networks', $adventurous_social_networks, 86940 );
	}
	echo $adventurous_social_networks;
}
endif; // adventurous_social_networks


/**
 * Adds in post and Page ID when viewing lists of posts and pages
 * This will help the admin to add the post ID in featured slider
 *
 * @param mixed $post_columns
 * @return post columns
 */
function adventurous_post_id_column( $post_columns ) {
	$beginning = array_slice( $post_columns, 0 ,1 );
	$beginning[ 'postid' ] = __( 'ID', 'adventurous'  );
	$ending = array_slice( $post_columns, 1 );
	$post_columns = array_merge( $beginning, $ending );
	return $post_columns;
}
add_filter( 'manage_posts_columns', 'adventurous_post_id_column' );
add_filter( 'manage_pages_columns', 'adventurous_post_id_column' );

function adventurous_posts_id_column( $col, $val ) {
	if ( 'postid' == $col ) echo $val;
}
add_action( 'manage_posts_custom_column', 'adventurous_posts_id_column', 10, 2 );
add_action( 'manage_pages_custom_column', 'adventurous_posts_id_column', 10, 2 );

function adventurous_posts_id_column_css() {
	echo '
	<style type="text/css">
	    #postid { width: 80px; }
	    @media screen and (max-width: 782px) {
	        .wp-list-table #postid, .wp-list-table #the-list .postid { display: none; }
	        .wp-list-table #the-list .is-expanded .postid {
	            padding-left: 30px;
	        }
	    }
    </style>';
}
add_action( 'admin_head-edit.php', 'adventurous_posts_id_column_css' );


if ( ! function_exists( 'adventurous_pagemenu_filter' ) ) :
/**
 * @uses wp_page_menu filter hook
 */
function adventurous_pagemenu_filter( $text ) {
	$replace = array(
		'current_page_item'     => 'current-menu-item'
	);

	$text = str_replace( array_keys( $replace ), $replace, $text );
  	return $text;

}
endif; // adventurous_pagemenu_filter
add_filter('wp_page_menu', 'adventurous_pagemenu_filter');


if ( ! function_exists( 'adventurous_breadcrumb_display' ) ) :
/**
 * Display breadcrumb on header
 */
function adventurous_breadcrumb_display() {
	global $post, $wp_query;

	// Front page displays in Reading Settings
	$page_on_front = get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts');

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();

	if ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) {
		return false;
	}
	else {
		if ( function_exists( 'bcn_display_list' ) ) {
			echo
			'<div class="breadcrumb container">
				<ul>';
					bcn_display_list();
					echo '
				</ul>
				<div class="row-end"></div>
			</div> <!-- .breadcrumb -->';
		}
	}

} // adventurous_breadcrumb_display
endif;

// Load  breadcrumb in adventurous_after_hgroup_wrap hook
add_action( 'adventurous_content_sidebar', 'adventurous_breadcrumb_display', 20 );


/**
 * This function loads Scroll Up Navigation
 *
 * @get the data value from theme options for disable
 * @uses adventurous_after_footer action to add the code in the footer
 * @uses set_transient and delete_transient
 */
function adventurous_scrollup() {
	//delete_transient( 'adventurous_scrollup' );

	if ( !$adventurous_scrollup = get_transient( 'adventurous_scrollup' ) ) {

		// get the data value from theme options
		$options = adventurous_get_options();
		echo '<!-- refreshing cache -->';

		//site stats, analytics header code
		if ( empty( $options['disable_scrollup'] ) ) {
			$adventurous_scrollup =  '<a href="#masthead" id="scrollup"></a>' ;
		}

		set_transient( 'adventurous_scrollup', $adventurous_scrollup, 86940 );
	}
	echo $adventurous_scrollup;
}
add_action( 'adventurous_after_footer', 'adventurous_scrollup', 10 );
