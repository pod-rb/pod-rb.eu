<?php
/**
 * Function to pass the slider effect parameters from php file to js file.
 */
function adventurous_pass_slider_value() {
	$options = adventurous_get_options();

	$transition_effect   = $options['transition_effect'];
	$transition_delay    = $options['transition_delay'] * 1000;
	$transition_duration = $options['transition_duration'] * 1000;
	
	wp_localize_script(
		'adventurous-slider',
		'js_value',
		array(
			'transition_effect' => $transition_effect,
			'transition_delay' => $transition_delay,
			'transition_duration' => $transition_duration
		)
	);
}// adventurous_pass_slider_value


/**
 * Shows Default Slider Demo if there is not iteam in Featured Post Slider
 */
function adventurous_default_sliders() {
	//delete_transient( 'adventurous_default_sliders' );

	if ( !$adventurous_default_sliders = get_transient( 'adventurous_default_sliders' ) ) {
		echo '<!-- refreshing cache -->';
		$adventurous_default_sliders = '
		<div id="main-slider">
			<section class="featured-slider">

				<article class="post hentry slides demo-image displayblock">
					<figure class="slider-image">
						<a title="Tiger" href="#">
							<img src="'. get_template_directory_uri() . '/images/demo/slider-1-1600x600.jpg" class="wp-post-image" alt="Tiger" title="Tiger">
						</a>
					</figure>
				</article><!-- .slides -->

				<article class="post hentry slides demo-image displaynone">
					<figure class="slider-image">
						<a title="Tiger" href="#">
							<img src="'. get_template_directory_uri() . '/images/demo/slider-2-1600x600.jpg" class="wp-post-image" alt="Tiger" title="Tiger">
						</a>
					</figure>
				</article><!-- .slides -->
			</section>
        	<div id="slider-nav">
        		<a class="slide-previous"><span>Previous</span></a>
        		<a class="slide-next"><span>Next</span></a>
        	</div>
			<div id="controllers"></div>
		</div><!-- #main-slider -->';

	set_transient( 'adventurous_default_sliders', $adventurous_default_sliders, 86940 );
	}
	echo $adventurous_default_sliders;
} // adventurous_default_sliders


if ( ! function_exists( 'adventurous_post_sliders' ) ) :
/**
 * Template for Featued Post Slider
 *
 * To override this in a child theme
 * simply create your own adventurous_post_sliders(), and that function will be used instead.
 *
 * @uses adventurous_header action to add it in the header
 * @since Adventurous 1.0
 */
function adventurous_post_sliders() {
	//delete_transient( 'adventurous_post_sliders' );

	if ( ! $output = get_transient( 'adventurous_post_sliders' ) ) {
		echo '<!-- refreshing cache -->';

		global $post;

		$options  = adventurous_get_options();
		
		$output = '
		<div id="main-slider">
        	<section class="featured-slider">';
				$loop = new WP_Query( array(
					'posts_per_page' => $options['slider_qty'],
					'post__in'		 => $options['featured_slider'],
					'orderby' 		 => 'post__in',
					'ignore_sticky_posts' => 1 // ignore sticky posts
				));
				$i=0; while ( $loop->have_posts()) : $loop->the_post(); $i++;
					$title_attribute = the_title_attribute( 'echo=0' );
					$excerpt = get_the_excerpt();
					if ( $i == 1 ) { $classes = 'post postid-'.$post->ID.' hentry slides displayblock'; } else { $classes = 'post postid-'.$post->ID.' hentry slides displaynone'; }
					$output .= '
					<article class="'.$classes.'">
						<figure class="slider-image">
							<a title="' . $title_attribute . '" href="' . esc_url( get_permalink() ) . '">
								'. get_the_post_thumbnail( $post->ID, 'slider', array( 'title' => $title_attribute, 'alt' => $title_attribute, 'class'	=> 'pngfix' ) ).'
							</a>
						</figure>';
						if ( empty ( $options['disable_slider_text'] ) ) {
							$output .= '
							<div class="entry-container">
								<header class="entry-header">
									<h2 class="entry-title">
										<a title="' . $title_attribute . '" href="' . esc_url( get_permalink() ) . '">'.the_title( '<span>','</span>', false ).'</a>
									</h2>
								</header>';
								if ( $excerpt !='') {
									$output .= '<div class="entry-content">'. $excerpt.'</div>';
								}
								$output .= '
							</div>';
						}

					$output .= '</article><!-- .slides -->';

				endwhile; wp_reset_postdata();
				$output .= '
			</section>
        	<div id="slider-nav">
        		<a class="slide-previous"><span>Previous</span></a>
        		<a class="slide-next"><span>Next</span></a>
        	</div>
        	<div id="controllers"></div>
  		</div><!-- #main-slider -->';

	set_transient( 'adventurous_post_sliders', $output, 86940 );
	}
	echo $output;
} // adventurous_post_sliders
endif;


if ( ! function_exists( 'adventurous_category_sliders' ) ) :
/**
 * Template for Featued Category Slider
 *
 * To override this in a child theme
 * simply create your own adventurous_category_sliders(), and that function will be used instead.
 *
 * @uses adventurous_header action to add it in the header
 * @since Adventurous 1.0
 */
function adventurous_category_sliders() {
	//delete_transient( 'adventurous_category_sliders' );

	if ( ( !$adventurous_category_sliders = get_transient( 'adventurous_category_sliders' ) ) ) {
		echo '<!-- refreshing cache -->';
		global $post;

		$options = adventurous_get_options();

		$adventurous_category_sliders = '
		<div id="main-slider">
        	<section class="featured-slider">';
				$loop = new WP_Query( array(
					'posts_per_page'		=> $options['slider_qty'],
					'category__in'			=> $options['slider_category'],
					'ignore_sticky_posts' 	=> 1 // ignore sticky posts
				));
				$i=0; while ( $loop->have_posts()) : $loop->the_post(); $i++;
					$title_attribute = the_title_attribute( 'echo=0' );
					$excerpt = get_the_excerpt();
					if ( $i == 1 ) { $classes = 'post pageid-'.$post->ID.' hentry slides displayblock'; } else { $classes = 'post pageid-'.$post->ID.' hentry slides displaynone'; }
					$adventurous_category_sliders .= '
					<article class="'.$classes.'">
						<figure class="slider-image">
							<a title="' . $title_attribute . '" href="' . esc_url( get_permalink() ) . '">
								'. get_the_post_thumbnail( $post->ID, 'slider', array( 'title' => $title_attribute, 'alt' => $title_attribute, 'class'	=> 'pngfix' ) ).'
							</a>
						</figure>';
						if ( empty ( $options['disable_slider_text'] ) ) {
							$adventurous_category_sliders .= '
							<div class="entry-container">
								<header class="entry-header">
									<h2 class="entry-title">
										<a title="' . $title_attribute . '" href="' . esc_url( get_permalink() ) . '">'.the_title( '<span>','</span>', false ).'</a>
									</h2>
								</header>';
								if ( $excerpt !='') {
									$adventurous_category_sliders .= '<div class="entry-content">'. $excerpt.'</div>';
								}
								$adventurous_category_sliders .= '
							</div>';
						}
					$adventurous_category_sliders .= '</article><!-- .slides -->';

				endwhile; wp_reset_postdata();
				$adventurous_category_sliders .= '
			</section>
        	<div id="slider-nav">
        		<a class="slide-previous"><span>Previous</span></a>
        		<a class="slide-next"><span>Next</span></a>
        	</div>
        	<div id="controllers"></div>
  		</div><!-- #main-slider -->';

	set_transient( 'adventurous_category_sliders', $adventurous_category_sliders, 86940 );
	}
	echo $adventurous_category_sliders;
} // adventurous_category_sliders
endif;



if ( ! function_exists( 'adventurous_slider_display' ) ) :
/**
 * Shows Slider
 */
function adventurous_slider_display() {
	global $post, $wp_query;

	$options = adventurous_get_options();

	// get data value from theme options
	$enableslider = $options['enable_slider'];
	$slidertype   = $options['select_slider_type'];

	// Front page displays in Reading Settings
	$page_on_front  = get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts');

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();

	if ( ( 'enable-slider-allpage' == $enableslider ) || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'enable-slider-homepage' == $enableslider ) ) :
		// This function passes the value of slider effect to js file
		if ( function_exists( 'adventurous_pass_slider_value' ) ) : adventurous_pass_slider_value(); endif;

		if (  'post-slider' == $slidertype ) {
			if ( !empty( $options['featured_slider'] ) && function_exists( 'adventurous_post_sliders' ) ) {
				adventurous_post_sliders();
			}
			else {
				echo '<p style="text-align: center">' . esc_attr__( 'You have selected Post Slider but you haven\'t added the Post ID in "Appearance => Theme Options => Featured Slider => Featured Post Slider Options"', 'adventurous' ) . '</p>';
			}
		}
		elseif (  'category-slider' == $slidertype ) {
			if ( function_exists( 'adventurous_category_sliders' ) ) {
				adventurous_category_sliders();
			}
			else {
				echo '<p style="text-align: center">' . esc_attr__( 'You have selected Category Slider but you haven\'t selected any categories in "Appearance => Theme Options => Featured Slider => Featured Category Slider Options"', 'adventurous' ) . '</p>';
			}
		}
		else {
			adventurous_default_sliders();
		}
	endif;
}
endif; // adventurous_slider_display

add_action( 'adventurous_before_main', 'adventurous_slider_display', 40 );