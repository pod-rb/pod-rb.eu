<?php
/**
 * Contains the fields used by the flow builder. Cannot be overridden by a theme file
 * Screen 1: Provider selection
 * Screen 2: Display Type selection; input: Provider
 * Screen 3: Gallery selection; input: Display Type
 * Screen 4: Layout selection; input: Gallery & Display Type
 *
 * @since 2.00
 */
global $photonic_flow_options, $photonic_flow_layout_options, $photonic_thumbnail_style;

$photonic_flow_layout_options = array(
	'square' => __('Square Grid', 'photonic'),
	'circle' => __('Circular Icon Grid', 'photonic'),
	'random' => __('Justified Grid', 'photonic'),
	'masonry' => __('Masonry', 'photonic'),
	'mosaic' => __('Mosaic', 'photonic'),
	'slideshow' => __('Slideshow', 'photonic'),
);

$photonic_flow_options = array(
	'screen-1' => array('wp', 'flickr', 'picasa', 'smugmug', '500px', 'zenfolio', 'instagram'),
	'screen-2' => array(
		'wp' => array(),
		'flickr' => array(
			'header' => '',
			'display' => array(
				'kind' => array(
					'type' => 'field_list',
					'list_type' => 'sequence',
					'list' => array(
						'display_type' => array(
							'desc' => __('What do you want to show?', 'photonic'),
							'type' => 'select',
							'options' => array(
								'' => '',
								'single-photo' => __('Single Photo', 'photonic'),
								'multi-photo' => __('Multiple Photos', 'photonic'),
								'album-photo' => __('Photos from an Album / Photoset', 'photonic'),
								'gallery-photo' => __('Photos from a Gallery', 'photonic'),
								'multi-album' => __('Multiple Albums', 'photonic'),
								'multi-gallery' => __('Multiple Galleries', 'photonic'),
								'collection' => __('Collections', 'photonic'),
							),
							'req' => 1,
						),
						'for' => array(
							'desc' => __('For whom?', 'photonic'),
							'type' => 'radio',
							'options' => array(
								'current' => __('Current user ', 'photonic'),
								'other' => __('Another user', 'photonic'),
								'group' => __('Group', 'photonic'),
								'any' => __('All users', 'photonic'),
							),
							'option-conditions' => array(
								'group' => array('display_type' => array('multi-photo')),
								'any' => array('display_type' => array('multi-photo')),
							),
							'req' => 1,
						),
						'login' => array(
							'desc' => __('User name, e.g. http://www.flickr.com/photos/<strong>username</strong>/', 'photonic'),
							'type' => 'text',
							'std' => '',
							'conditions' => array('for' => array('other')),
							'req' => 1,
						),
						'group' => array(
							'desc' => __('Group name, e.g. http://www.flickr.com/groups/<strong>groupname</strong>/', 'photonic'),
							'type' => 'text',
							'std' => '',
							'conditions' => array('for' => array('group')),
							'req' => 1,
						),
					),
				),
			),
		),
		'picasa' => array(),
		'smugmug' => array(),
		'500px' => array(),
		'zenfolio' => array(),
		'instagram' => array(),
	),
	'screen-3' => array(
		'wp' => array(),
		'flickr' => array(
			'header' => __('Build your gallery', 'photonic'),
			'single-photo' => array(
				'header' => __('Pick a photo', 'photonic'),
				'desc' => __('From the list below pick the single photo you wish to display.', 'photonic'),
				'display' => array(
					'container' => array(
						'type' => 'placeholder',
						'markup' => "<div class=\"photonic-flow-selector-container\" data-photonic-flow-selector-mode=\"single\" data-photonic-flow-selector-for=\"selected_data\">\n{{placeholder_value}}</div>\n",
					),
				),
			),
			'multi-photo' => array(
				'header' => __('All your photos', 'photonic'),
				'desc' => __('You can show all your photos, or apply tags to show some of them.', 'photonic'),
				'display' => array(
					'tags' => array(
						'desc' => __('Tags', 'photonic'),
						'type' => 'text',
						'hint' => __('Comma-separated list of tags', 'photonic')
					),

					'tag_mode' => array(
						'desc' => __('Tag mode', 'photonic'),
						'type' => 'select',
						'options' => array(
							'any' => __('Any tag', 'photonic'),
							'all' => __('All tags', 'photonic'),
						),
					),

					'text' => array(
						'desc' => __('With text', 'photonic'),
						'type' => 'text',
					),

					'container' => array(
						'type' => 'placeholder',
						'markup' => "<div class=\"photonic-flow-selector-container\" data-photonic-flow-selector-mode=\"none\" data-photonic-flow-selector-for=\"selected_data\">\n{{placeholder_value}}</div>\n",
					),
				),
			),
			'album-photo' => array(
				'header' => __('Pick your album', 'photonic'),
				'desc' => __('From the list below pick the album whose photos you wish to display. Photos from that album will show up on your site.', 'photonic'),
				'display' => array(
					'container' => array(
						'type' => 'placeholder',
						'markup' => "<div class=\"photonic-flow-selector-container\" data-photonic-flow-selector-mode=\"single\" data-photonic-flow-selector-for=\"selected_data\">\n{{placeholder_value}}</div>\n",
					),
				),
			),
			'gallery-photo' => array(
				'header' => __('Pick your gallery', 'photonic'),
				'desc' => __('From the list below pick the gallery whose photos you wish to display. Photos from that gallery will show up on your site.', 'photonic'),
				'display' => array(
					'container' => array(
						'type' => 'placeholder',
						'markup' => "<div class=\"photonic-flow-selector-container\" data-photonic-flow-selector-mode=\"single\" data-photonic-flow-selector-for=\"selected_data\">\n{{placeholder_value}}</div>\n",
					),
				),
			),
			'multi-album' => array(
				'header' => __('Pick your albums / photosets', 'photonic'),
				'desc' => __('From the list below pick the albums / photosets you wish to display. Each album will show up as a single thumbnail.', 'photonic'),
				'display' => array(
					'selection' => array(
						'desc' => __('What do you want to show?', 'photonic'),
						'type' => 'select',
						'options' => array(
							'all' => __('All albums / photosets', 'photonic'),
							'selected' => __('Selected albums / photosets', 'photonic'),
							'not-selected' => __('All except selected albums / photosets', 'photonic'),
						),
						'hint' => __('If you pick "All", your selections below will be ignored.', 'photonic'),
						'req' => 1,
					),
					'container' => array(
						'type' => 'placeholder',
						'markup' => "<div class=\"photonic-flow-selector-container\" data-photonic-flow-selector-mode=\"multi\" data-photonic-flow-selector-for=\"selected_data\">\n{{placeholder_value}}</div>\n",
					),
				),
			),
			'multi-gallery' => array(
				'header' => __('Pick your galleries', 'photonic'),
				'desc' => __('From the list below pick the galleries you wish to display. Each album will show up as a single thumbnail.', 'photonic'),
				'display' => array(
					'selection' => array(
						'desc' => __('What do you want to show?', 'photonic'),
						'type' => 'select',
						'options' => array(
							'all' => __('All galleries', 'photonic'),
							'selected' => __('Selected galleries', 'photonic'),
							'not-selected' => __('All except selected galleries', 'photonic'),
						),
						'req' => 1,
					),
					'container' => array(
						'type' => 'placeholder',
						'markup' => "<div class=\"photonic-flow-selector-container\" data-photonic-flow-selector-mode=\"multi\" data-photonic-flow-selector-for=\"selected_data\">\n{{placeholder_value}}</div>\n",
					),
				),
			),
			'collection' => array(
				'header' => __('Pick your collections', 'photonic'),
				'desc' => __('From the list below pick the collections you wish to display. The albums within the collections will show up as single thumbnails.', 'photonic'),
				'display' => array(
					'selection' => array(
						'desc' => __('What do you want to show?', 'photonic'),
						'type' => 'select',
						'options' => array(
							'all' => __('All collections', 'photonic'),
							'selected' => __('Selected collections', 'photonic'),
							'not-selected' => __('All except selected collections', 'photonic'),
						),
						'req' => 1,
					),
					'container' => array(
						'type' => 'placeholder',
						'markup' => "<div class=\"photonic-flow-selector-container\" data-photonic-flow-selector-mode=\"multi\" data-photonic-flow-selector-for=\"selected_data\">\n{{placeholder_value}}</div>\n",
					),
				),
			),
		),
		'picasa' => array(),
		'smugmug' => array(),
		'500px' => array(),
		'zenfolio' => array(),
		'instagram' => array(),
	),
	'screen-4' => array(
		'wp' => array(),
		'flickr' => array(),
		'picasa' => array(),
		'smugmug' => array(),
		'500px' => array(),
		'zenfolio' => array(),
		'instagram' => array(),
	),
	'screen-5' => array(
		'wp' => array(),
		'flickr' => array(
			'L3' => array(
				'collections_display' => array(
					'desc' => __('Expand Collections', 'photonic'),
					'type' => 'select',
					'options' => array(
						'' => '',
						'lazy' => __('Lazy loading', 'photonic'),
						'expanded' => __('Expanded upfront', 'photonic'),
					),
					'hint' => __('The Collections API is slow, so, if you are displaying collections, pick <a href="https://aquoid.com/plugins/photonic/flickr/flickr-collections/">lazy loading</a> if your collections have many albums / photosets.', 'photonic'),
				),
				'headers' => array(
					'desc' => __('Show Collection Header', 'photonic'),
					'type' => 'multi-select',
					'options' => array(
						'thumbnail' => __('Hide collection thumbnail', 'photonic'),
						'title' => __('Hide collection title', 'photonic'),
						'counter' => __('Hide counts', 'photonic'),
					),
					'hint' => __('Numeric values only', 'photonic'),
				),
			),
		),
		'picasa' => array(),
		'smugmug' => array(),
		'500px' => array(),
		'zenfolio' => array(),
		'instagram' => array(),
		'slideshow' => array(
			'slideshow-style' => array(
				'desc' => __('Slideshow display style', 'photonic'),
				'type' => 'image-select',
				'options' => array(
					'strip-below' => __('Thumbnail strip or buttons below slideshow', 'photonic'),
					'strip-above' => __('Thumbnail strip above slideshow', 'photonic'),
					'strip-right' => __('Thumbnail strip to the right of slideshow', 'photonic'),
					'no-strip' => __('No thumbnails or buttons for the slideshow', 'photonic'),
				),
				'std' => $photonic_thumbnail_style,
			),
			'strip-style' => array(
				'desc' => __('Thumbnails or buttons for the strip?', 'photonic'),
				'type' => 'image-select',
				'options' => array(
					'thumbs' => __('Thumbnails', 'photonic'),
					'button' => __('Buttons', 'photonic'),
				),
				'hint' => __('If you choose "Buttons" those are only shown below the slideshow.', 'photonic'),
				'std' => 'thumbs',
			),
			'controls' => array(
				'desc' => __('Slideshow Controls', 'photonic'),
				'type' => 'select',
				'options' => array(
					'hide' => __('Hide', 'photonic'),
					'show' => __('Show', 'photonic'),
				),
				'hint' => __('Shows Previous and Next buttons on the slideshow.', 'photonic'),
			),
			'fx' => array(
				'desc' => __('Slideshow Effects', 'photonic'),
				'type' => 'select',
				'options' => array(
					'fade' => __('Fade', 'photonic'),
					'slide' => __('Slide', 'photonic'),
				),
				'hint' => __('Determines if a photo in a slideshow should fade in or slide in.', 'photonic')
			),
			'timeout' => array(
				'desc' => __('Time between slides in ms', 'photonic'),
				'type' => 'text',
				'std' => '',
				'hint' => __('Please enter numbers only', 'photonic')
			),
			'speed' => array(
				'desc' => __('Time for each transition in ms', 'photonic'),
				'type' => 'text',
				'std' => '',
				'hint' => __('How fast do you want the fade or slide effect to happen?', 'photonic')
			),
			'pause' => array(
				'desc' => __('Pause upon hover?', 'photonic'),
				'type' => 'select',
				'options' => array(
					'0' => __('No', 'photonic'),
					'1' => __('Yes', 'photonic'),
				),
				'hint' => __('Should the slideshow pause when you hover over it?', 'photonic')
			),
		),
		'L1' => array(
			'count' => array(
				'desc' => __('Number of photos to show', 'photonic'),
				'type' => 'text',
				'hint' => __('Numeric values only', 'photonic'),
			),
			'more' => array(
				'desc' => __('"More" button text', 'photonic'),
				'type' => 'text',
				'hint' => __('Will show a "More" button with the specified text if the number of photos is higher than the above entry. Leave blank to show no button', 'photonic'),
			),
		),
		'L2' => array(
			'count' => array(
				'desc' => __('Number of photos to show', 'photonic'),
				'type' => 'text',
				'hint' => __('Numeric values only', 'photonic'),
			),
		),
	),
);