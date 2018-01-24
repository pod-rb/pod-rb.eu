<?php
/**
 * Adventurous Customizer/Theme Options
 *
 * @package Catch Themes
 * @subpackage Adventurous
 * @since Adventurous 1.6.2
 */

/**
 * Implements Adventurous theme options into Theme Customizer.
 *
 * @param $wp_customize Theme Customizer object
 * @return void
 *
 * @since Adventurous 1.6.2
 */
function adventurous_customize_register( $wp_customize ) {
	$options  = adventurous_get_options();
	$defaults = adventurous_get_defaults();

	//Custom Controls
	require trailingslashit( get_template_directory() ) . 'inc/panel/customizer/customizer-custom-controls.php';

	$theme_slug = 'adventurous_';

	$settings_page_tabs = array(
		'theme_options' => array(
			'id' 			=> 'theme_options',
			'title' 		=> esc_html__( 'Theme Options', 'adventurous' ),
			'description' 	=> esc_html__( 'Basic theme Options', 'adventurous' ),
			'sections' 		=> array(
				'header_options' => array(
					'id' 			=> 'header_options',
					'title' 		=> esc_html__( 'Header Options', 'adventurous' ),
					'description' 	=> '',
				),
				'content_featured_image_options' => array(
					'id' 			=> 'content_featured_image_options',
					'title' 		=> esc_html__( 'Content Featured Image Options', 'adventurous' ),
					'description' 	=> '',
				),
				'promotion_headline_options' => array(
					'id' 			=> 'promotion_headline_options',
					'title' 		=> esc_html__( 'Promotion Headline Options', 'adventurous' ),
					'description' 	=> '',
				),
				'homepage_settings' => array(
					'id' 			=> 'homepage_settings',
					'title' 		=> esc_html__( 'Homepage/Frontpage Settings', 'adventurous' ),
					'description' 	=> '',
				),
				'layout_options' => array(
					'id' 			=> 'layout_options',
					'title' 		=> esc_html__( 'Layout Options', 'adventurous' ),
					'description' 	=> '',
				),
				'search_text_settings' => array(
					'id' 			=> 'search_text_settings',
					'title' 		=> esc_html__( 'Search Text Settings', 'adventurous' ),
					'description' 	=> '',
				),
				'excerpt_more_tag_settings' => array(
					'id' 			=> 'excerpt_more_tag_settings',
					'title' 		=> esc_html__( 'Excerpt / More Tag Settings', 'adventurous' ),
					'description' 	=> '',
				),
				'disable_scrollup' => array(
					'id' 			=> 'disable_scrollup',
					'title' 		=> esc_html__( 'Scroll Up', 'adventurous' ),
					'description' 	=> '',
				),
				'custom_css' => array(
					'id' 			=> 'custom_css',
					'title' 		=> esc_html__( 'Custom CSS', 'adventurous' ),
					'description' 	=> '',
				),

			),
		),
		'featured_content' => array(
			'id' 			=> 'featured_content',
			'title' 		=> esc_html__( 'Featured Content', 'adventurous' ),
			'description' 	=> esc_html__( 'Featured Content', 'adventurous' ),
			'sections' 		=> array(
				'featured_content_settings' => array(
					'id' 			=> 'featured_content_settings',
					'title' 		=> esc_html__( 'Featured Content Settings', 'adventurous' ),
					'description' 	=> '',
				),
			)
		),

		'featured_slider' => array(
			'id' 			=> 'featured_slider',
			'title' 		=> esc_html__( 'Featured Slider', 'adventurous' ),
			'description' 	=> esc_html__( 'Featured Slider', 'adventurous' ),
			'sections' 		=> array(
				'slider_options' => array(
					'id' 			=> 'slider_options',
					'title' 		=> esc_html__( 'Slider Options', 'adventurous' ),
					'description' 	=> '',
				),
			)
		),

		'social_links' => array(
			'id' 			=> 'social_links',
			'title' 		=> esc_html__( 'Social Links', 'adventurous' ),
			'description' 	=> esc_html__( 'Add your social links here', 'adventurous' ),
			'sections' 		=> array(
				'predefined_social_icons' => array(
					'id' 			=> 'predefined_social_icons',
					'title' 		=> esc_html__( 'Predefined Social Icons', 'adventurous' ),
					'description' 	=> '',
				),
			),
		),
	);

	//Add Panels and sections
	foreach ( $settings_page_tabs as $panel ) {
		$wp_customize->add_panel(
			$theme_slug . $panel['id'],
			array(
				'priority' 		=> 200,
				'capability' 	=> 'edit_theme_options',
				'title' 		=> $panel['title'],
				'description' 	=> $panel['description'],
			)
		);

		// Loop through tabs for sections
		foreach ( $panel['sections'] as $section ) {
			$params = array(
								'title'			=> $section['title'],
								'description'	=> $section['description'],
								'panel'			=> $theme_slug . $panel['id']
							);

			if ( isset( $section['active_callback'] ) ) {
				$params['active_callback'] = $section['active_callback'];
			}

			$wp_customize->add_section(
				// $id
				$theme_slug . $section['id'],
				// parameters
				$params

			);
		}
	}

	$settings_parameters = array(
		//Header Featured image Options
		'enable_featured_header_image' => array(
			'id' 			=> 'enable_featured_header_image',
			'title' 		=> esc_html__( 'Enable Featured Header Image', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'select',
			'sanitize' 		=> 'adventurous_sanitize_select',
			'section' 		=> 'header_image',
			'default' 		=> $defaults['enable_featured_header_image'],
			'choices'		=> adventurous_enable_header_featured_image(),
		),
		'page_featured_image' => array(
			'id' 			=> 'page_featured_image',
			'title' 		=> esc_html__( 'Page/Post Featured Image Size', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'select',
			'sanitize' 		=> 'adventurous_sanitize_select',
			'section' 		=> 'header_image',
			'default' 		=> $defaults['page_featured_image'],
			'choices'		=> adventurous_page_post_featured_image_size(),
		),
		'featured_header_image_alt' => array(
			'id' 			=> 'featured_header_image_alt',
			'title' 		=> esc_html__( 'Featured Header Image Alt/Title Tag', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'text',
			'sanitize' 		=> 'sanitize_text_field',
			'section' 		=> 'header_image',
			'default' 		=> $defaults['featured_header_image_alt']
		),
		'featured_header_image_url' => array(
			'id' 			=> 'featured_header_image_url',
			'title' 		=> esc_html__( 'Featured Header Image Link URL', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'url',
			'sanitize' 		=> 'esc_url_raw',
			'section' 		=> 'header_image',
			'default' 		=> $defaults['featured_header_image_url']
		),
		'featured_header_image_base' => array(
			'id' 			=> 'featured_header_image_base',
			'title' 		=> esc_html__( 'Check to Open Link in New Tab/Window', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'checkbox',
			'sanitize' 		=> 'adventurous_sanitize_checkbox',
			'section' 		=> 'header_image',
			'default' 		=> $defaults['featured_header_image_base']
		),
		'reset_featured_image' => array(
			'id' 			=> 'reset_featured_image',
			'title' 		=> esc_html__( 'Check to Reset Header Featured Image Options', 'adventurous' ),
			'description'	=> esc_html__( 'Please refresh the customizer after saving if reset option is used', 'adventurous' ),
			'transport'		=> 'postMessage',
			'field_type' 	=> 'checkbox',
			'sanitize' 		=> 'adventurous_sanitize_checkbox',
			'section' 		=> 'header_image',
			'default' 		=> $defaults['reset_featured_image']
		),

		//Header Options
		'disable_header_right_sidebar' => array(
			'id' 			=> 'disable_header_right_sidebar',
			'title' 		=> esc_html__( 'Check to Disable Header Right Sidebar', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'checkbox',
			'sanitize' 		=> 'adventurous_sanitize_checkbox',
			'panel' 		=> 'theme_options',
			'section' 		=> 'header_options',
			'default' 		=> $defaults['disable_header_right_sidebar']
		),


		//Promotion Headline Options
		'enable_promotion' => array(
			'id' 			=> 'enable_promotion',
			'title' 		=> esc_html__( 'Enable Promotion', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'select',
			'sanitize' 		=> 'adventurous_sanitize_select',
			'panel' 		=> 'theme_options',
			'section' 		=> 'promotion_headline_options',
			'default' 		=> $defaults['enable_promotion'],
			'choices'		=> adventurous_enable_featured_content_options(),
		),
		'homepage_headline' => array(
			'id' 			=> 'homepage_headline',
			'title' 		=> esc_html__( 'Headline Text', 'adventurous' ),
			'description' 	=> esc_html__( 'Appropriate Words: 10', 'adventurous' ),
			'field_type' 	=> 'textarea',
			'sanitize' 		=> 'wp_kses_post',
			'panel' 		=> 'theme_options',
			'section' 		=> 'promotion_headline_options',
			'default' 		=> $defaults['homepage_headline']
		),
		'homepage_subheadline' => array(
			'id' 			=> 'homepage_subheadline',
			'title' 		=> esc_html__( 'Subheadline Text', 'adventurous' ),
			'description' 	=> esc_html__( 'Appropriate Words: 15', 'adventurous' ),
			'field_type' 	=> 'textarea',
			'sanitize' 		=> 'wp_kses_post',
			'panel' 		=> 'theme_options',
			'section' 		=> 'promotion_headline_options',
			'default' 		=> $defaults['homepage_subheadline']
		),
		'homepage_headline_button' => array(
			'id' 			=> 'homepage_headline_button',
			'title' 		=> esc_html__( 'Button Text ', 'adventurous' ),
			'description'	=> esc_html__( 'Appropriate Words: 3', 'adventurous' ),
			'field_type' 	=> 'text',
			'sanitize' 		=> 'sanitize_text_field',
			'panel' 		=> 'theme_options',
			'section' 		=> 'promotion_headline_options',
			'default' 		=> $defaults['homepage_headline_button']
		),
		'homepage_headline_url' => array(
			'id' 			=> 'homepage_headline_url',
			'title' 		=> esc_html__( 'Button Link', 'adventurous' ),
			'description'	=> esc_html__( 'Add link for your homepage headline button', 'adventurous' ),
			'field_type' 	=> 'url',
			'sanitize' 		=> 'esc_url_raw',
			'panel' 		=> 'theme_options',
			'section' 		=> 'promotion_headline_options',
			'default' 		=> $defaults['homepage_headline_url']
		),
		'homepage_headline_target' => array(
			'id' 			=> 'homepage_headline_target',
			'title' 		=> esc_html__( 'Check to Open Link in New Window/Tab? ', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'checkbox',
			'sanitize' 		=> 'adventurous_sanitize_checkbox',
			'panel' 		=> 'theme_options',
			'section' 		=> 'promotion_headline_options',
			'default' 		=> $defaults['homepage_headline_target']
		),
		'disable_homepage_headline' => array(
			'id' 			=> 'disable_homepage_headline',
			'title' 		=> esc_html__( 'Check to Disable Homepage Headline', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'checkbox',
			'sanitize' 		=> 'adventurous_sanitize_checkbox',
			'panel' 		=> 'theme_options',
			'section' 		=> 'promotion_headline_options',
			'default' 		=> $defaults['disable_homepage_headline']
		),
		'disable_homepage_subheadline' => array(
			'id' 			=> 'disable_homepage_subheadline',
			'title' 		=> esc_html__( 'Check to Disable Homepage Subheadline', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'checkbox',
			'sanitize' 		=> 'adventurous_sanitize_checkbox',
			'panel' 		=> 'theme_options',
			'section' 		=> 'promotion_headline_options',
			'default' 		=> $defaults['disable_homepage_subheadline']
		),
		'disable_homepage_button' => array(
			'id' 			=> 'disable_homepage_button',
			'title' 		=> esc_html__( 'Check to Disable Homepage Button', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'checkbox',
			'sanitize' 		=> 'adventurous_sanitize_checkbox',
			'panel' 		=> 'theme_options',
			'section' 		=> 'promotion_headline_options',
			'default' 		=> $defaults['disable_homepage_button']
		),

		//Homepage/Frontpage Settings
		'enable_posts_home' => array(
			'id' 			=> 'enable_posts_home',
			'title' 		=> esc_html__( 'Check to Disable Latest Posts', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'checkbox',
			'sanitize' 		=> 'adventurous_sanitize_checkbox',
			'panel' 		=> 'theme_options',
			'section' 		=> 'homepage_settings',
			'default' 		=> $defaults['enable_posts_home']
		),
		'front_page_category' => array(
			'id' 			=> 'front_page_category',
			'title' 		=> esc_html__( 'Homepage posts categories:', 'adventurous' ),
			'description'	=> esc_html__( 'Only posts that belong to the categories selected here will be displayed on the front page', 'adventurous' ),
			'field_type' 	=> 'category-multiple',
			'sanitize' 		=> 'adventurous_sanitize_category_list',
			'panel' 		=> 'theme_options',
			'section' 		=> 'homepage_settings',
			'default' 		=> $defaults['front_page_category']
		),

		//Content Featured Image Options
		'featured_image' => array(
			'id' 			=> 'featured_image',
			'title' 		=> esc_html__( 'Content Featured Image Size', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'select',
			'sanitize' 		=> 'adventurous_sanitize_select',
			'panel' 		=> 'theme_options',
			'section' 		=> 'content_featured_image_options',
			'default' 		=> $defaults['featured_image'],
			'choices'		=> adventurous_content_featured_image_size(),
		),

		//Layout Options
		'sidebar_layout' => array(
			'id' 			=> 'sidebar_layout',
			'title' 		=> esc_html__( 'Sidebar Layout Options', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'select',
			'sanitize' 		=> 'adventurous_sanitize_select',
			'panel' 		=> 'theme_options',
			'section' 		=> 'layout_options',
			'default' 		=> $defaults['sidebar_layout'],
			'choices'		=> adventurous_sidebar_layout_options(),
		),
		'content_layout' => array(
			'id' 			=> 'content_layout',
			'title' 		=> esc_html__( 'Full Content Display', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'select',
			'sanitize' 		=> 'adventurous_sanitize_select',
			'panel' 		=> 'theme_options',
			'section' 		=> 'layout_options',
			'default' 		=> $defaults['content_layout'],
			'choices'		=> adventurous_content_layout_options(),
		),
		'reset_layout' => array(
			'id' 			=> 'reset_layout',
			'title' 		=> esc_html__( 'Check to Reset Layout', 'adventurous' ),
			'description'	=> esc_html__( 'Please refresh the customizer after saving if reset option is used', 'adventurous' ),
			'field_type' 	=> 'checkbox',
			'sanitize' 		=> 'adventurous_sanitize_checkbox',
			'panel' 		=> 'theme_options',
			'section' 		=> 'layout_options',
			'default' 		=> $defaults['reset_layout']
		),

		//Search Settings
		'search_display_text' => array(
			'id' 			=> 'search_display_text',
			'title' 		=> esc_html__( 'Default Display Text in Search', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'text',
			'sanitize' 		=> 'sanitize_text_field',
			'panel' 		=> 'theme_options',
			'section' 		=> 'search_text_settings',
			'default' 		=> $defaults['search_display_text']
		),

		//Excerpt More Settings
		'more_tag_text' => array(
			'id' 			=> 'more_tag_text',
			'title' 		=> esc_html__( 'More Tag Text', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'text',
			'sanitize' 		=> 'sanitize_text_field',
			'panel' 		=> 'theme_options',
			'section' 		=> 'excerpt_more_tag_settings',
			'default' 		=> $defaults['more_tag_text']
		),
		'excerpt_length' => array(
			'id' 			=> 'excerpt_length',
			'title' 		=> esc_html__( 'Excerpt length(words)', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'number',
			'sanitize' 		=> 'adventurous_sanitize_number_range',
			'panel' 		=> 'theme_options',
			'section' 		=> 'excerpt_more_tag_settings',
			'default' 		=> $defaults['excerpt_length'],
			'input_attrs' 	=> array(
					            'style' => 'width: 45px;',
					            'min'   => 0,
					            'max'   => 999999,
					            'step'  => 1,
					        	)
		),
		'reset_moretag' => array(
			'id' 			=> 'reset_moretag',
			'title' 		=> esc_html__( 'Check to Reset Excerpt', 'adventurous' ),
			'description'	=> esc_html__( 'Please refresh the customizer after saving if reset option is used', 'adventurous' ),
			'field_type' 	=> 'checkbox',
			'sanitize' 		=> 'adventurous_sanitize_checkbox',
			'panel' 		=> 'theme_options',
			'section' 		=> 'excerpt_more_tag_settings',
			'default' 		=> $defaults['reset_moretag']
		),

		//Scroll Settings
		'disable_scrollup' => array(
			'id' 			=> 'disable_scrollup',
			'title' 		=> esc_html__( 'Check to disable scroll up', 'adventurous' ),
			'description' 	=> '',
			'field_type' 	=> 'checkbox',
			'sanitize' 		=> 'adventurous_sanitize_checkbox',
			'panel' 		=> 'theme_options',
			'section' 		=> 'disable_scrollup',
			'default' 		=> $defaults['disable_scrollup'],
		),

		//Custom Css
		'custom_css' => array(
			'id' 			=> 'custom_css',
			'title' 		=> esc_html__( 'Enter your custom CSS styles', 'adventurous' ),
			'description' 	=> '',
			'field_type' 	=> 'textarea',
			'sanitize' 		=> 'adventurous_sanitize_custom_css',
			'panel' 		=> 'theme_options',
			'section' 		=> 'custom_css',
			'default' 		=> $defaults['custom_css']
		),

		//Featured Content
		'enable-featured' => array(
			'id'              => 'enable-featured',
			'title'           => esc_html__( 'Enable Featured Content', 'adventurous' ),
			'description'     => '',
			'field_type'      => 'select',
			'sanitize'        => 'adventurous_sanitize_select',
			'panel'           => 'featured_content',
			'section'         => 'featured_content_settings',
			'default'         => $defaults['enable-featured'],
			'choices'         => adventurous_enable_featured_content_options(),
		),
		'homepage_featured_headline' => array(
			'id'              => 'homepage_featured_headline',
			'title'           => esc_html__( 'Featured Content Headline Text', 'adventurous' ),
			'description'     => esc_html__( 'Leave empty if you want to remove headline', 'adventurous' ),
			'field_type'      => 'text',
			'sanitize'        => 'sanitize_text_field',
			'panel'           => 'featured_content',
			'section'         => 'featured_content_settings',
			'default'         => $defaults['homepage_featured_headline'],
			'active_callback' => 'adventurous_is_featured_content_active'
		),
		'homepage_featured_subheadline' => array(
			'id'              => 'homepage_featured_subheadline',
			'title'           => esc_html__( 'Featured Content Subheadline Text ', 'adventurous' ),
			'description'     => esc_html__( 'Leave empty if you want to remove Subheadline', 'adventurous' ),
			'field_type'      => 'text',
			'sanitize'        => 'sanitize_text_field',
			'panel'           => 'featured_content',
			'section'         => 'featured_content_settings',
			'default'         => $defaults['homepage_featured_subheadline'],
			'active_callback' => 'adventurous_is_featured_content_active'
		),

		'homepage_featured_qty' => array(
			'id'              => 'homepage_featured_qty',
			'title'           => esc_html__( 'Number of Featured Content', 'adventurous' ),
			'description'     => '',
			'field_type'      => 'number',
			'sanitize'        => 'adventurous_sanitize_number_range',
			'panel'           => 'featured_content',
			'section'         => 'featured_content_settings',
			'default'         => $defaults['homepage_featured_qty'],
			'active_callback' => 'adventurous_is_featured_content_active',
			'input_attrs'     => array(
					            'style' => 'width: 45px;',
					            'min'   => 0,
					            'max'   => 20,
					            'step'  => 1,
					        	)
		),
		'homepage_featured_layout' => array(
			'id'              => 'homepage_featured_layout',
			'title'           => esc_html__( 'Featured Content Layout', 'adventurous' ),
			'description'     => '',
			'field_type'      => 'radio',
			'sanitize'        => 'adventurous_sanitize_select',
			'panel'           => 'featured_content',
			'section'         => 'featured_content_settings',
			'default'         => $defaults['homepage_featured_layout'],
			'active_callback' => 'adventurous_is_featured_content_active',
			'choices'         => adventurous_featured_content_layouts(),
		),

		//Slider Options
		'enable_slider' => array(
			'id' 			=> 'enable_slider',
			'title' 		=> esc_html__( 'Enable Slider', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'select',
			'sanitize' 		=> 'adventurous_sanitize_select',
			'panel' 		=> 'featured_slider',
			'section' 		=> 'slider_options',
			'default' 		=> $defaults['enable_slider'],
			'choices'		=> adventurous_enable_slider_options(),
		),
		'transition_effect' => array(
			'id' 				=> 'transition_effect',
			'title' 			=> esc_html__( 'Transition Effect', 'adventurous' ),
			'description'		=> '',
			'field_type' 		=> 'select',
			'sanitize' 			=> 'adventurous_sanitize_select',
			'panel' 			=> 'featured_slider',
			'section' 			=> 'slider_options',
			'default' 			=> $defaults['transition_effect'],
			'active_callback'	=> 'adventurous_is_slider_active',
			'choices'			=> adventurous_transition_effects(),
		),
		'transition_delay' => array(
			'id' 				=> 'transition_delay',
			'title' 			=> esc_html__( 'Transition Delay', 'adventurous' ),
			'description'		=> '',
			'field_type' 		=> 'number',
			'sanitize' 			=> 'adventurous_sanitize_number_range',
			'panel' 			=> 'featured_slider',
			'section' 			=> 'slider_options',
			'default' 			=> $defaults['transition_delay'],
			'active_callback'	=> 'adventurous_is_slider_active',
			'input_attrs' 		=> array(
						            'style' => 'width: 45px;',
						            'min'   => 0,
						            'max'   => 999999999,
						            'step'  => 1,
						        	)
		),
		'transition_duration' => array(
			'id' 				=> 'transition_duration',
			'title' 			=> esc_html__( 'Transition Length', 'adventurous' ),
			'description'		=> '',
			'field_type' 		=> 'number',
			'sanitize' 			=> 'adventurous_sanitize_number_range',
			'panel' 			=> 'featured_slider',
			'section' 			=> 'slider_options',
			'default' 			=> $defaults['transition_duration'],
			'active_callback'	=> 'adventurous_is_slider_active',
			'input_attrs' 		=> array(
						            'style' => 'width: 45px;',
						            'min'   => 0,
						            'max'   => 999999999,
						            'step'  => 1,
						        	)
		),
		'select_slider_type' => array(
			'id' 				=> 'select_slider_type',
			'title' 			=> esc_html__( 'Select Slider Type', 'adventurous' ),
			'description'		=> '',
			'field_type' 		=> 'select',
			'sanitize' 			=> 'adventurous_sanitize_select',
			'panel' 			=> 'featured_slider',
			'section' 			=> 'slider_options',
			'default' 			=> $defaults['select_slider_type'],
			'active_callback'	=> 'adventurous_is_slider_active',
			'choices'			=> adventurous_slider_types(),
		),
		'slider_qty' => array(
			'id' 				=> 'slider_qty',
			'title' 			=> esc_html__( 'Number of Slides', 'adventurous' ),
			'description'		=> esc_html__( 'Customizer page needs to be refreshed after saving if number of slides is changed', 'adventurous' ),
			'field_type' 		=> 'number',
			'sanitize' 			=> 'adventurous_sanitize_number_range',
			'panel' 			=> 'featured_slider',
			'section' 			=> 'slider_options',
			'default' 			=> $defaults['slider_qty'],
			'active_callback'	=> 'adventurous_is_demo_slider_inactive',
			'input_attrs' 		=> array(
						            'style' => 'width: 45px;',
						            'min'   => 0,
						            'max'   => 20,
						            'step'  => 1,
						        	)
		),
		'disable_slider_text' => array(
			'id' 				=> 'disable_slider_text',
			'title' 			=> esc_html__( 'Check to disable slider text', 'adventurous' ),
			'description'		=> '',
			'field_type' 		=> 'checkbox',
			'sanitize' 			=> 'adventurous_sanitize_checkbox',
			'panel' 			=> 'featured_slider',
			'section' 			=> 'slider_options',
			'default' 			=> $defaults['disable_slider_text'],
			'active_callback'	=> 'adventurous_is_slider_active',
		),

		//Featured Post Slider
		'exclude_slider_post' => array(
			'id' 				=> 'exclude_slider_post',
			'title' 			=> esc_html__( 'Check to Exclude Slider posts from Homepage posts', 'adventurous' ),
			'description'		=> esc_html__( 'Please refresh the customizer after saving if reset option is used', 'adventurous' ),
			'field_type' 		=> 'checkbox',
			'sanitize' 			=> 'adventurous_sanitize_checkbox',
			'panel' 			=> 'featured_slider',
			'section' 			=> 'slider_options',
			'default' 			=> $defaults['exclude_slider_post'],
			'active_callback' 	=> 'adventurous_is_post_slider_active'
		),

		//Featured Category Slider
		'slider_category' => array(
			'id' 				=> 'slider_category',
			'title' 			=> esc_html__( 'Select Slider Categories', 'adventurous' ),
			'description'		=> esc_html__( 'Use this only is you want to display posts from Specific Categories in Featured Slider', 'adventurous' ),
			'field_type' 		=> 'category-multiple',
			'sanitize' 			=> 'adventurous_sanitize_category_list',
			'panel' 			=> 'featured_slider',
			'section' 			=> 'slider_options',
			'default' 			=> $defaults['slider_category'],
			'active_callback' 	=> 'adventurous_is_category_slider_active'
		),

		//Social Links
		'social_facebook' => array(
			'id' 			=> 'social_facebook',
			'title' 		=> esc_html__( 'Facebook', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'url',
			'sanitize' 		=> 'esc_url_raw',
			'panel' 		=> 'social_links',
			'section' 		=> 'predefined_social_icons',
			'default' 		=> $defaults['social_facebook']
		),
		'social_twitter' => array(
			'id' 			=> 'social_twitter',
			'title' 		=> esc_html__( 'Twitter', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'url',
			'sanitize' 		=> 'esc_url_raw',
			'panel' 		=> 'social_links',
			'section' 		=> 'predefined_social_icons',
			'default' 		=> $defaults['social_twitter']
		),
		'social_googleplus' => array(
			'id' 			=> 'social_googleplus',
			'title' 		=> esc_html__( 'Google+', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'url',
			'sanitize' 		=> 'esc_url_raw',
			'panel' 		=> 'social_links',
			'section' 		=> 'predefined_social_icons',
			'default' 		=> $defaults['social_googleplus']
		),
		'social_pinterest' => array(
			'id' 			=> 'social_pinterest',
			'title' 		=> esc_html__( 'Pinterest', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'url',
			'sanitize' 		=> 'esc_url_raw',
			'panel' 		=> 'social_links',
			'section' 		=> 'predefined_social_icons',
			'default' 		=> $defaults['social_pinterest']
		),
		'social_youtube' => array(
			'id' 			=> 'social_youtube',
			'title' 		=> esc_html__( 'Youtube', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'url',
			'sanitize' 		=> 'esc_url_raw',
			'panel' 		=> 'social_links',
			'section' 		=> 'predefined_social_icons',
			'default' 		=> $defaults['social_youtube']
		),
		'social_vimeo' => array(
			'id' 			=> 'social_vimeo',
			'title' 		=> esc_html__( 'Vimeo', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'url',
			'sanitize' 		=> 'esc_url_raw',
			'panel' 		=> 'social_links',
			'section' 		=> 'predefined_social_icons',
			'default' 		=> $defaults['social_vimeo']
		),
		'social_linkedin' => array(
			'id' 			=> 'social_linkedin',
			'title' 		=> esc_html__( 'LinkedIn', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'url',
			'sanitize' 		=> 'esc_url_raw',
			'panel' 		=> 'social_links',
			'section' 		=> 'predefined_social_icons',
			'default' 		=> $defaults['social_linkedin']
		),
		'social_slideshare' => array(
			'id' 			=> 'social_slideshare',
			'title' 		=> esc_html__( 'Slideshare', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'url',
			'sanitize' 		=> 'esc_url_raw',
			'panel' 		=> 'social_links',
			'section' 		=> 'predefined_social_icons',
			'default' 		=> $defaults['social_slideshare']
		),
		'social_foursquare' => array(
			'id' 			=> 'social_foursquare',
			'title' 		=> esc_html__( 'Foursquare', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'url',
			'sanitize' 		=> 'esc_url_raw',
			'panel' 		=> 'social_links',
			'section' 		=> 'predefined_social_icons',
			'default' 		=> $defaults['social_foursquare']
		),
		'social_flickr' => array(
			'id' 			=> 'social_flickr',
			'title' 		=> esc_html__( 'Flickr', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'url',
			'sanitize' 		=> 'esc_url_raw',
			'panel' 		=> 'social_links',
			'section' 		=> 'predefined_social_icons',
			'default' 		=> $defaults['social_flickr']
		),
		'social_tumblr' => array(
			'id' 			=> 'social_tumblr',
			'title' 		=> esc_html__( 'Tumblr', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'url',
			'sanitize' 		=> 'esc_url_raw',
			'panel' 		=> 'social_links',
			'section' 		=> 'predefined_social_icons',
			'default' 		=> $defaults['social_tumblr']
		),
		'social_deviantart' => array(
			'id' 			=> 'social_deviantart',
			'title' 		=> esc_html__( 'deviantART', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'url',
			'sanitize' 		=> 'esc_url_raw',
			'panel' 		=> 'social_links',
			'section' 		=> 'predefined_social_icons',
			'default' 		=> $defaults['social_deviantart']
		),
		'social_dribbble' => array(
			'id' 			=> 'social_dribbble',
			'title' 		=> esc_html__( 'Dribbble', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'url',
			'sanitize' 		=> 'esc_url_raw',
			'panel' 		=> 'social_links',
			'section' 		=> 'predefined_social_icons',
			'default' 		=> $defaults['social_dribbble']
		),
		'social_myspace' => array(
			'id' 			=> 'social_myspace',
			'title' 		=> esc_html__( 'MySpace', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'url',
			'sanitize' 		=> 'esc_url_raw',
			'panel' 		=> 'social_links',
			'section' 		=> 'predefined_social_icons',
			'default' 		=> $defaults['social_myspace']
		),
		'social_wordpress' => array(
			'id' 			=> 'social_wordpress',
			'title' 		=> esc_html__( 'WordPress', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'url',
			'sanitize' 		=> 'esc_url_raw',
			'panel' 		=> 'social_links',
			'section' 		=> 'predefined_social_icons',
			'default' 		=> $defaults['social_wordpress']
		),
		'social_rss' => array(
			'id' 			=> 'social_rss',
			'title' 		=> esc_html__( 'RSS', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'url',
			'sanitize' 		=> 'esc_url_raw',
			'panel' 		=> 'social_links',
			'section' 		=> 'predefined_social_icons',
			'default' 		=> $defaults['social_rss']
		),
		'social_delicious' => array(
			'id' 			=> 'social_delicious',
			'title' 		=> esc_html__( 'Delicious', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'url',
			'sanitize' 		=> 'esc_url_raw',
			'panel' 		=> 'social_links',
			'section' 		=> 'predefined_social_icons',
			'default' 		=> $defaults['social_delicious']
		),
		'social_lastfm' => array(
			'id' 			=> 'social_lastfm',
			'title' 		=> esc_html__( 'Last.fm', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'url',
			'sanitize' 		=> 'esc_url_raw',
			'panel' 		=> 'social_links',
			'section' 		=> 'predefined_social_icons',
			'default' 		=> $defaults['social_lastfm']
		),
		'social_instagram' => array(
			'id' 			=> 'social_instagram',
			'title' 		=> esc_html__( 'Instagram', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'url',
			'sanitize' 		=> 'esc_url_raw',
			'panel' 		=> 'social_links',
			'section' 		=> 'predefined_social_icons',
			'default' 		=> $defaults['social_instagram']
		),
		'social_github' => array(
			'id' 			=> 'social_github',
			'title' 		=> esc_html__( 'GitHub', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'url',
			'sanitize' 		=> 'esc_url_raw',
			'panel' 		=> 'social_links',
			'section' 		=> 'predefined_social_icons',
			'default' 		=> $defaults['social_github']
		),
		'social_vkontakte' => array(
			'id' 			=> 'social_vkontakte',
			'title' 		=> esc_html__( 'Vkontakte', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'url',
			'sanitize' 		=> 'esc_url_raw',
			'panel' 		=> 'social_links',
			'section' 		=> 'predefined_social_icons',
			'default' 		=> $defaults['social_vkontakte']
		),
		'social_myworld' => array(
			'id' 			=> 'social_myworld',
			'title' 		=> esc_html__( 'My World', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'url',
			'sanitize' 		=> 'esc_url_raw',
			'panel' 		=> 'social_links',
			'section' 		=> 'predefined_social_icons',
			'default' 		=> $defaults['social_myworld']
		),
		'social_odnoklassniki' => array(
			'id' 			=> 'social_odnoklassniki',
			'title' 		=> esc_html__( 'Odnoklassniki', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'url',
			'sanitize' 		=> 'esc_url_raw',
			'panel' 		=> 'social_links',
			'section' 		=> 'predefined_social_icons',
			'default' 		=> $defaults['social_odnoklassniki']
		),
		'social_goodreads' => array(
			'id' 			=> 'social_goodreads',
			'title' 		=> esc_html__( 'Goodreads', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'url',
			'sanitize' 		=> 'esc_url_raw',
			'panel' 		=> 'social_links',
			'section' 		=> 'predefined_social_icons',
			'default' 		=> $defaults['social_goodreads']
		),
		'social_skype' => array(
			'id' 			=> 'social_skype',
			'title' 		=> esc_html__( 'Skype', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'url',
			'sanitize' 		=> 'sanitize_text_field',
			'panel' 		=> 'social_links',
			'section' 		=> 'predefined_social_icons',
			'default' 		=> $defaults['social_skype']
		),
		'social_soundcloud' => array(
			'id' 			=> 'social_soundcloud',
			'title' 		=> esc_html__( 'Soundcloud', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'url',
			'sanitize' 		=> 'esc_url_raw',
			'panel' 		=> 'social_links',
			'section' 		=> 'predefined_social_icons',
			'default' 		=> $defaults['social_soundcloud']
		),
		'social_email' => array(
			'id' 			=> 'social_email',
			'title' 		=> esc_html__( 'Email', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'url',
			'sanitize' 		=> 'sanitize_email',
			'panel' 		=> 'social_links',
			'section' 		=> 'predefined_social_icons',
			'default' 		=> $defaults['social_email']
		),
		'social_contact' => array(
			'id' 			=> 'social_contact',
			'title' 		=> esc_html__( 'Contact', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'url',
			'sanitize' 		=> 'esc_url_raw',
			'panel' 		=> 'social_links',
			'section' 		=> 'predefined_social_icons',
			'default' 		=> $defaults['social_contact']
		),
		'social_xing' => array(
			'id' 			=> 'social_xing',
			'title' 		=> esc_html__( 'Xing', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'url',
			'sanitize' 		=> 'esc_url_raw',
			'panel' 		=> 'social_links',
			'section' 		=> 'predefined_social_icons',
			'default' 		=> $defaults['social_xing']
		),
		'social_meetup' => array(
			'id' 			=> 'social_meetup',
			'title' 		=> esc_html__( 'Meetup', 'adventurous' ),
			'description'	=> '',
			'field_type' 	=> 'url',
			'sanitize' 		=> 'esc_url_raw',
			'panel' 		=> 'social_links',
			'section' 		=> 'predefined_social_icons',
			'default' 		=> $defaults['social_meetup']
		),
	);

	//@remove Remove if block when WordPress 4.8 is released
	if( !function_exists( 'has_custom_logo' ) ) {
		$settings_logo = array(
			'featured_logo_header' => array(
				'id' 			=> 'featured_logo_header',
				'title' 		=> esc_html__( 'Logo', 'adventurous' ),
				'description'	=> '',
				'field_type' 	=> 'image',
				'sanitize' 		=> 'adventurous_sanitize_image',
				'section' 		=> 'title_tagline',
				'default' 		=> $defaults['featured_logo_header'],
				'priority'		=> '15'
			),
			'remove_header_logo' => array(
				'id' 			=> 'remove_header_logo',
				'title' 		=> esc_html__( 'Check to Disable Logo', 'adventurous' ),
				'description'	=> '',
				'field_type' 	=> 'checkbox',
				'sanitize' 		=> 'adventurous_sanitize_checkbox',
				'section' 		=> 'title_tagline',
				'default' 		=> $defaults['remove_header_logo'],
				'priority'		=> '16'
			)
		);

		$settings_parameters = array_merge( $settings_parameters, $settings_logo);
	}

	//@remove Remove if block and custom_css from $settings_paramater when WordPress 5.0 is released
	if( function_exists( 'wp_update_custom_css_post' ) ) {
		unset( $settings_parameters['custom_css'] );
	}

	foreach ( $settings_parameters as $option ) {
		$transport = isset( $option[ 'transport' ] ) ? $option[ 'transport' ] : 'refresh';
		if( 'image' == $option['field_type'] ) {
			$wp_customize->add_setting(
				// $id
				$theme_slug . 'options[' . $option['id'] . ']',
				// parameters array
				array(
					'type'				=> 'option',
					'sanitize_callback'	=> $option['sanitize'],
					'default'			=> $option['default']
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Image_Control(
					$wp_customize,$theme_slug . 'options[' . $option['id'] . ']',
					array(
						'label'		=> $option['title'],
						'section'   => $theme_slug . $option['section'],
						'settings'  => $theme_slug . 'options[' . $option['id'] . ']',
					)
				)
			);
		}
		else if ('checkbox' == $option['field_type'] ) {
			$wp_customize->add_setting(
				// $id
				$theme_slug . 'options[' . $option['id'] . ']',
				// parameters array
				array(
					'type'				=> 'option',
					'sanitize_callback'	=> $option['sanitize'],
					'default'			=> $option['default'],
					'transport'			=> $transport				)
			);

			$params = array(
						'label'		=> $option['title'],
						'settings'  => $theme_slug . 'options[' . $option['id'] . ']',
						'name'  	=> $theme_slug . 'options[' . $option['id'] . ']',
					);

			if ( isset( $option['active_callback']  ) ){
				$params['active_callback'] = $option['active_callback'];
			}

			if ( 'header_image' == $option['section'] ){
				$params['section'] = $option['section'];
			}
			else {
				$params['section']	= $theme_slug . $option['section'];
			}

			$wp_customize->add_control(
				new Adventurous_Customize_Checkbox(
					$wp_customize,$theme_slug . 'options[' . $option['id'] . ']',
					$params
				)
			);
		}
		else if ('category-multiple' == $option['field_type'] ) {
			$wp_customize->add_setting(
				// $id
				$theme_slug . 'options[' . $option['id'] . ']',
				// parameters array
				array(
					'type'				=> 'option',
					'sanitize_callback'	=> $option['sanitize'],
					'default'			=> $option['default']
				)
			);

			$params = array(
						'label'			=> $option['title'],
						'section'		=> $theme_slug . $option['section'],
						'settings'		=> $theme_slug . 'options[' . $option['id'] . ']',
						'description'	=> $option['description'],
						'name'	 		=> $theme_slug . 'options[' . $option['id'] . ']',
					);

			if ( isset( $option['active_callback']  ) ){
				$params['active_callback'] = $option['active_callback'];
			}

			$wp_customize->add_control(
				new Adventurous_Customize_Dropdown_Categories_Control (
					$wp_customize,
					$theme_slug . 'options[' . $option['id'] . ']',
					$params
				)
			);
		}
		else {
			//Normal Loop
			$wp_customize->add_setting(
				// $id
				$theme_slug . 'options[' . $option['id'] . ']',
				// parameters array
				array(
					'default'			=> $option['default'],
					'type'				=> 'option',
					'sanitize_callback'	=> $option['sanitize']
				)
			);

			// Add setting control
			$params = array(
					'label'			=> $option['title'],
					'settings'		=> $theme_slug . 'options[' . $option['id'] . ']',
					'type'			=> $option['field_type'],
					'description'   => $option['description'],
				) ;

			if ( isset( $option['choices']  ) ){
				$params['choices'] = $option['choices'];
			}

			if ( isset( $option['active_callback']  ) ){
				$params['active_callback'] = $option['active_callback'];
			}

			if ( isset( $option['input_attrs']  ) ){
				$params['input_attrs'] = $option['input_attrs'];
			}

			if ( 'header_image' == $option['section'] ){
				$params['section'] = $option['section'];
			}
			else {
				$params['section']	= $theme_slug . $option['section'];
			}

			$wp_customize->add_control(
				// $id
				$theme_slug . 'options[' . $option['id'] . ']',
				$params
			);
		}
	}

	//Add featured content elements with respect to no of featured content
	for ( $i = 1; $i <= $options['homepage_featured_qty']; $i++ ) {
		$wp_customize->add_setting(
			// $id
			$theme_slug . 'options[homepage_featured_content_note][' . $i . ']',
			// parameters array
			array(
				'type'				=> 'option',
				'sanitize_callback'	=> 'sanitize_text_field'
			)
		);

		$wp_customize->add_control(
			new Adventurous_Note_Control(
				$wp_customize, $theme_slug . 'options[homepage_featured_content_note][' . $i . ']',
				array(
					'label'           => sprintf( esc_html__( 'Featured Content #%s', 'adventurous' ), $i ),
					'section'         => $theme_slug .'featured_content_settings',
					'settings'        => $theme_slug . 'options[homepage_featured_content_note][' . $i . ']',
					'active_callback' => 'adventurous_is_featured_content_active'
				)
			)
		);

		$wp_customize->add_setting(
			// $id
			$theme_slug . 'options[homepage_featured_image][' . $i . ']',
			// parameters array
			array(
				'type'				=> 'option',
				'sanitize_callback'	=> 'adventurous_sanitize_image'
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize, $theme_slug . 'options[homepage_featured_image][' . $i . ']',
				array(
					'label'           => esc_html__( 'Image', 'adventurous' ),
					'section'         => $theme_slug .'featured_content_settings',
					'settings'        => $theme_slug . 'options[homepage_featured_image][' . $i . ']',
					'active_callback' => 'adventurous_is_featured_content_active'
				)
			)
		);

		$wp_customize->add_setting(
			// $id
			$theme_slug . 'options[homepage_featured_url][' . $i . ']',
			// parameters array
			array(
				'type'				=> 'option',
				'sanitize_callback'	=> 'esc_url_raw'
			)
		);

		$wp_customize->add_control(
			$theme_slug . 'options[homepage_featured_url][' . $i . ']',
			array(
				'label'           => esc_html__( 'Link URL', 'adventurous' ),
				'section'         => $theme_slug .'featured_content_settings',
				'settings'        => $theme_slug . 'options[homepage_featured_url][' . $i . ']',
				'type'            => 'url',
				'active_callback' => 'adventurous_is_featured_content_active'
			)
		);

		$wp_customize->add_setting(
			// $id
			$theme_slug . 'options[homepage_featured_base][' . $i . ']',
			// parameters array
			array(
				'type'				=> 'option',
				'sanitize_callback'	=> 'adventurous_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			$theme_slug . 'options[homepage_featured_base][' . $i . ']',
			array(
				'label'           => esc_html__( 'Target. Open Link in New Window?', 'adventurous' ),
				'section'         => $theme_slug .'featured_content_settings',
				'settings'        => $theme_slug . 'options[homepage_featured_base][' . $i . ']',
				'type'            => 'checkbox',
				'active_callback' => 'adventurous_is_featured_content_active'
			)
		);

		$wp_customize->add_setting(
			// $id
			$theme_slug . 'options[homepage_featured_title][' . $i . ']',
			// parameters array
			array(
				'type'				=> 'option',
				'sanitize_callback'	=> 'sanitize_text_field'
			)
		);

		$wp_customize->add_control(
			$theme_slug . 'options[homepage_featured_title][' . $i . ']',
			array(
				'label'           => esc_html__( 'Title', 'adventurous' ),
				'section'         => $theme_slug .'featured_content_settings',
				'settings'        => $theme_slug . 'options[homepage_featured_title][' . $i . ']',
				'description'     => esc_html__( 'Leave empty if you want to remove title', 'adventurous' ),
				'type'            => 'text',
				'active_callback' => 'adventurous_is_featured_content_active'
			)
		);

		$wp_customize->add_setting(
			// $id
			$theme_slug . 'options[homepage_featured_content][' . $i . ']',
			// parameters array
			array(
				'type'				=> 'option',
				'sanitize_callback'	=> 'wp_kses_post'
			)
		);

		$wp_customize->add_control(
			$theme_slug . 'options[homepage_featured_content][' . $i . ']',
			array(
				'label'           => esc_html__( 'Content', 'adventurous' ),
				'section'         => $theme_slug .'featured_content_settings',
				'settings'        => $theme_slug . 'options[homepage_featured_content][' . $i . ']',
				'description'     => esc_html__( 'Appropriate Words: 10', 'adventurous' ),
				'type'            => 'textarea',
				'active_callback' => 'adventurous_is_featured_content_active'
			)
		);
	}

	//Add featured post elements with respect to no of featured sliders
	for ( $i = 1; $i <= $options['slider_qty']; $i++ ) {
		$wp_customize->add_setting(
			// $id
			$theme_slug . 'options[featured_slider][' . $i . ']',
			// parameters array
			array(
				'type'				=> 'option',
				'sanitize_callback'	=> 'adventurous_sanitize_post_id'
			)
		);

		$wp_customize->add_control(
			$theme_slug . 'options[featured_slider][' . $i . ']',
			array(
				'label'		=> sprintf( esc_html__( 'Featured Post Slider #%s', 'adventurous' ), $i ),
				'section'   => $theme_slug .'slider_options',
				'settings'  => $theme_slug . 'options[featured_slider][' . $i . ']',
				'type'		=> 'text',
					'input_attrs' => array(
	        		'style' => 'width: 100px;'
	    		),
				'active_callback' 	=> 'adventurous_is_post_slider_active'
			)
		);
	}


	// Reset all settings to default
	$wp_customize->add_section( 'adventurous_reset_all_settings', array(
		'description'	=> esc_html__( 'Caution: Reset all settings to default. Refresh the page after save to view full effects.', 'adventurous' ),
		'priority' 		=> 700,
		'title'    		=> esc_html__( 'Reset all settings', 'adventurous' ),
	) );

	$wp_customize->add_setting( 'adventurous_options[reset_all_settings]', array(
		'capability'		=> 'edit_theme_options',
		'sanitize_callback' => 'adventurous_sanitize_checkbox',
		'transport'			=> 'postMessage',
		'type'				=> 'option',
	) );

	$wp_customize->add_control( 'adventurous_options[reset_all_settings]', array(
		'label'    => esc_html__( 'Check to reset all settings to default', 'adventurous' ),
		'section'  => 'adventurous_reset_all_settings',
		'settings' => 'adventurous_options[reset_all_settings]',
		'type'     => 'checkbox'
	) );
	// Reset all settings to default end

	//Important Links
	$wp_customize->add_section( 'important_links', array(
		'priority' 		=> 999,
		'title'   	 	=> esc_html__( 'Important Links', 'adventurous' ),
	) );

	/**
	 * Has dummy Sanitizaition function as it contains no value to be sanitized
	 */
	$wp_customize->add_setting( 'important_links', array(
		'sanitize_callback'	=> 'sanitize_text_field',
	) );

	$wp_customize->add_control( new Adventurous_Important_Links( $wp_customize, 'important_links', array(
        'label'   	=> esc_html__( 'Important Links', 'adventurous' ),
        'section'  	=> 'important_links',
        'settings' 	=> 'important_links',
        'type'     	=> 'important_links',
    ) ) );
    //Important Links End
}
add_action( 'customize_register', 'adventurous_customize_register' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously for adventurous.
 * And flushes out all transient data on preview
 *
 * @since Adventurous 1.6.3
 */
function adventurous_customize_preview() {
	//Remove transients on preview
	adventurous_flush_transients();
}
add_action( 'customize_preview_init', 'adventurous_customize_preview' );
add_action( 'customize_save', 'adventurous_customize_preview' );



/*
 * Clearing the cache if any changes in Admin Theme Option
 */
function adventurous_flush_transients() {
	delete_transient( 'adventurous_featured_image' ); // featured header image
	delete_transient( 'adventurous_inline_css' ); // Custom Inline CSS
	delete_transient( 'adventurous_post_sliders' ); // featured post slider
	delete_transient( 'adventurous_category_sliders' ); // featured category slider
	delete_transient( 'adventurous_default_sliders' ); //Default slider
	delete_transient( 'adventurous_homepage_headline' ); // Homepage Headline Message
	delete_transient( 'adventurous_default_featured_content' ); // Homepage Default Featured Content
	delete_transient( 'adventurous_homepage_featured_content' ); // Homepage Featured Content
	delete_transient( 'adventurous_footer_content' ); // Footer Content
	delete_transient( 'adventurous_social_networks' ); // Social Networks
	delete_transient( 'adventurous_scrollup' ); // scrollup
}


/*
 * Clearing the cache if any changes in post or page
 */
function adventurous_flush_post_transients(){
	delete_transient( 'adventurous_post_sliders' ); // featured post slider
	delete_transient( 'adventurous_category_sliders' ); // featured category slider
}
//Add action hook here save post
add_action( 'save_post', 'adventurous_flush_post_transients' );


/**
 * Custom scripts and styles on Customizer for Adventurous
 *
 * @since Adventurous 1.4
 */
function adventurous_customize_scripts() {
	wp_enqueue_script( 'adventurous_customizer_custom', get_template_directory_uri() . '/inc/panel/js/customizer-custom-scripts.js', array( 'jquery' ), '20140108', true );
}
add_action( 'customize_controls_enqueue_scripts', 'adventurous_customize_scripts' );


/**
 * Function to reset date with respect to condition
 */
function adventurous_reset_data() {
	$options  = adventurous_get_options();
    if ( $options['reset_all_settings'] ) {
    	remove_theme_mods();

    	delete_option( 'adventurous_options' );

        // Flush out all transients	on reset
        adventurous_flush_transients();

        return;
    }

	$defaults = adventurous_get_defaults();

	//Reset Header Featured Image Options
	if ( $options['reset_featured_image'] ) {
		unset( $options['enable_featured_header_image'] );
		unset( $options['page_featured_image'] );
		unset( $options['featured_header_image_alt'] );
		unset( $options['featured_header_image_url'] );
		unset( $options['featured_header_image_base'] );
		unset( $options['reset_featured_image'] );
        
        remove_theme_mod( 'header_image' );
	}

	//Reset Color Options
	if ( $options['reset_moretag'] ) {
		unset( $options['more_tag_text'] );
		unset( $options['excerpt_length'] );
		
		unset( $options['reset_moretag'] );
	}

	//Reset Color Options
	if ( $options['reset_layout'] ) {
		unset( $options['sidebar_layout'] );
		unset( $options['content_layout'] );
		unset( $options['featured_image'] );
        
        unset( $options['reset_layout'] );
	}

	update_option( 'adventurous_options', $options );

	// Flush out all transients	on reset
	adventurous_flush_transients();
}
add_action( 'customize_save_after', 'adventurous_reset_data' );

//Active callbacks for customizer
require trailingslashit( get_template_directory() ) . 'inc/panel/customizer/customizer-active-callbacks.php';

//Sanitize functions for customizer
require trailingslashit( get_template_directory() ) . 'inc/panel/customizer/customizer-sanitize-functions.php';

// Add Upgrade to Pro Button.
require trailingslashit( get_template_directory() ) . 'inc/panel/customizer/upgrade-button/class-customize.php';