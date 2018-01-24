<?php
global $photonic_smugmug_options;

$photonic_smugmug_options = array(
	array("name" => "SmugMug settings",
		"desc" => "Control settings for SmugMug",
		"category" => "smug-settings",
		"type" => "section",),

	array("name" => "SmugMug API Key",
		"desc" => "To make use of the SmugMug functionality you have to use your <a href='https://api.smugmug.com/api/developer/apply'>SmugMug API Key</a>. When you are setting up your API Key, make sure that you add <code>".site_url()."</code> as your Callback URL. <strong>Without that your authentication will not work.</strong>",
		"id" => "smug_api_key",
		"grouping" => "smug-settings",
		"type" => "text",
		"std" => ""),

	array("name" => "SmugMug API Secret",
		"desc" => "You have to enter the Secret provided by SmugMug after you have registered your application.",
		"id" => "smug_api_secret",
		"grouping" => "smug-settings",
		"type" => "text",
		"std" => ""),

	array("name" => "Private Photos",
		"desc" => "Let visitors of your site login to SmugMug to see private photos for which they have permissions (will show a login button if they are not logged in)",
		"id" => "smug_allow_oauth",
		"grouping" => "smug-settings",
		"type" => "checkbox",
		"std" => ""),

	array("name" => "Login Box Text",
		"desc" => "If private photos are enabled, this is the text users will see before the login button (you can use HTML tags here)",
		"id" => "smug_login_box",
		"grouping" => "smug-settings",
		"type" => "textarea",
		"std" => "Some features that you are trying to access may be visible to logged in users of SmugMug only. Please login if you want to see them. Clicking the button below will open a new tab / window, so if popups are disabled, please enable them. After you have authorized this site to access your profile, please <a href='javascript:document.location.reload();'>refresh</a> this window."),

	array("name" => "Login Button Text",
		"desc" => "If private photos are enabled, this is the text users will see before the login button (you can use HTML tags other than &lt;a&gt; here)",
		"id" => "smug_login_button",
		"grouping" => "smug-settings",
		"type" => "text",
		"std" => "Login"),

	array("name" => "Thumbnail size",
		"desc" => "Pick a standard size provided by SmugMug for your thumbnails:",
		"id" => "smug_thumb_size",
		"grouping" => "smug-settings",
		"type" => "select",
		"options" => array("Tiny" => "Tiny", "Thumb" => "Thumb", "Small" => "Small"),
		"std" => "Tiny"),

	array("name" => "Main image size",
		"desc" => "When you click on a thumbnail this size will be displayed if you are using a slideshow. If you are not using a slideshow you will be taken to the SmugMug page:",
		"id" => "smug_main_size",
		"grouping" => "smug-settings",
		"type" => "select",
		"options" => array(
			'4K' => '4K (not always available)',
			'5K' => '5K (not always available)',
			"Medium" => "Medium",
			"Original" => "Original (not always available)",
			"Large" => "Large",
			'Largest' => 'Largest',
			"XLarge" => "XLarge (not always available)",
			"X2Large" => "X2Large (not always available)",
			"X3Large" => "X3Large (not always available)",
		),
		"std" => "Largest"),

	array("name" => "Tile image size",
		"desc" => "<strong>This is applicable only if you are using the random tiled gallery layout.</strong> This size will be used as the image for the tiles. Picking a size smaller than the Main image size above will save bandwidth if your users <strong>don't click</strong> on individual images. Conversely, leaving this the same as the Main image size will save bandwidth if your users <strong>do click</strong> on individual images:",
		"id" => "smug_tile_size",
		"grouping" => "smug-settings",
		"type" => "select",
		"options" => array(
			"same" => "Same as Main image size",
			"Small" => "Small",
			'4K' => '4K (not always available)',
			'5K' => '5K (not always available)',
			"Medium" => "Medium",
			"Original" => "Original (not always available)",
			"Large" => "Large",
			'Largest' => 'Largest',
			"XLarge" => "XLarge (not always available)",
			"X2Large" => "X2Large (not always available)",
			"X3Large" => "X3Large (not always available)",
		),
		"std" => "same"),

	array("name" => "Disable lightbox linking",
		"desc" => "Check this to disable linking the album title and/or thumbnail, or the title in the lightbox to the SmugMug page for the album / photo.",
		"id" => "smug_disable_title_link",
		"grouping" => "smug-settings",
		"type" => "checkbox",
		"std" => ""),

	array("name" => "Show \"Buy\" link",
		"desc" => "Click to show a link to purchase the photo. This shows up in a lightbox, so it enables lightbox linking to be enabled.",
		"id" => "smug_disable_title_link",
		"grouping" => "smug-settings",
		"type" => "checkbox",
		"std" => ""),

	array("name" => "Photo titles and captions",
		"desc" => "What do you want to show as the photo title in the tooltip and lightbox?",
		"id" => "smug_title_caption",
		"grouping" => "smug-settings",
		"type" => "select",
		"options" => Photonic::title_caption_options(),
		"std" => "title-desc"),

	array("name" => "Album Thumbnails (with other Albums)",
		"desc" => "Control settings for SmugMug Album thumbnails",
		"category" => "smug-albums",
		"type" => "section",),

	array("name" => "What is this section?",
		"desc" => "Options in this section are in effect when you use the shortcode format <code>[gallery type='smugmug' nick_name='abc']</code> or <code>[gallery type='smugmug' nick_name='abc' view='albums']</code> or <code>[gallery type='smugmug' nick_name='abc' view='tree']</code>. They are used to control the Album's thumbnail display",
		"grouping" => "smug-albums",
		"type" => "blurb",),

	array("name" => "Album Title Display",
		"desc" => "How do you want the title of the Album?",
		"id" => "smug_albums_album_title_display",
		"grouping" => "smug-albums",
		"type" => "radio",
		"options" => photonic_title_styles(),
		"std" => "tooltip"),

	array("name" => "Hide Photo Count in Title Display",
		"desc" => "This will hide the number of photos in your Album's title.",
		"id" => "smug_hide_albums_album_photos_count_display",
		"grouping" => "smug-albums",
		"type" => "checkbox",
		"std" => ""),

	array("name" => "Hide thumbnails for Password-protected albums",
		"desc" => "This will hide the thumbnail of password-protected albums.",
		"id" => "smug_hide_password_protected_thumbnail",
		"grouping" => "smug-albums",
		"type" => "checkbox",
		"std" => ""),

	array("name" => "Constrain Albums Per Row",
		"desc" => "How do you want the control the number of album thumbnails per row? This can be overridden by adding the '<code>columns</code>' parameter to the '<code>gallery</code>' shortcode.",
		"id" => "smug_albums_album_per_row_constraint",
		"grouping" => "smug-albums",
		"type" => "select",
		"options" => array("padding" => "Fix the padding around the thumbnails",
			"count" => "Fix the number of thumbnails per row",
		),
		"std" => "padding"),

	array("name" => "Constrain by padding",
		"desc" => " If you have constrained by padding above, enter the number of pixels here to pad the thumbs by",
		"id" => "smug_albums_album_constrain_by_padding",
		"grouping" => "smug-albums",
		"type" => "text",
		"hint" => "Enter the number of pixels here (don't enter 'px'). Non-integers will be ignored.",
		"std" => "15"),

	array("name" => "Constrain by number of thumbnails",
		"desc" => " If you have constrained by number of thumbnails per row above, enter the number of thumbnails",
		"id" => "smug_albums_album_constrain_by_count",
		"grouping" => "smug-albums",
		'type' => 'select',
		'options' => photonic_selection_range(1, 25),
		"std" => 5),

	array("name" => "Album Thumbnail Border",
		"id" => "smug_albums_album_thumb_border",
		"grouping" => "smug-albums",
		"type" => 'border',
		"options" => array(),
		"std" => photonic_default_border(),
	),

	array("name" => "Album Thumbnail - Padding between border and image",
		"desc" => "Setup the padding between the album thumbnail and its border.",
		"id" => "smug_albums_album_thumb_padding",
		"grouping" => "smug-albums",
		'type' => 'padding',
		'options' => array(),
		'std' => photonic_default_padding(),
	),

	array("name" => "Photos (Main Page)",
		"desc" => "Control settings for SmugMug Photos when displayed in your page",
		"category" => "smug-photos",
		"type" => "section",),

	array("name" => "What is this section?",
		"desc" => "Options in this section are in effect when you use the shortcode format <code>[gallery type='smugmug' nick_name='abc' view='album' album_id='pqr' album_key='xyz']</code>
			or <code>[gallery type='smugmug' nick_name='abc' view='images' album_id='pqr' album_key='xyz']</code>. In other words, the photos are printed directly on the page.",
		"grouping" => "smug-photos",
		"type" => "blurb",),

	array("name" => "Hide Album Thumbnail",
		"desc" => "This will hide the thumbnail for your SmugMug Album.",
		"id" => "smug_hide_album_thumbnail",
		"grouping" => "smug-photos",
		"type" => "checkbox",
		"std" => ""),

	array("name" => "Hide Album Title",
		"desc" => "This will hide the title for your SmugMug Album.",
		"id" => "smug_hide_album_title",
		"grouping" => "smug-photos",
		"type" => "checkbox",
		"std" => ""),

	array("name" => "Hide Number of Photos",
		"desc" => "This will hide the number of photos in your SmugMug Album.",
		"id" => "smug_hide_album_photo_count",
		"grouping" => "smug-photos",
		"type" => "checkbox",
		"std" => ""),

	array("name" => "Photo Title Display",
		"desc" => "How do you want the title of the photos?",
		"id" => "smug_photo_title_display",
		"grouping" => "smug-photos",
		"type" => "radio",
		"options" => photonic_title_styles(),
		"std" => "tooltip"),

	array("name" => "Constrain Photos Per Row",
		"desc" => "How do you want the control the number of photo thumbnails per row by default? This can be overridden by adding the '<code>columns</code>' parameter to the '<code>gallery</code>' shortcode.",
		"id" => "smug_photos_per_row_constraint",
		"grouping" => "smug-photos",
		"type" => "select",
		"options" => array("padding" => "Fix the padding around the thumbnails",
			"count" => "Fix the number of thumbnails per row",
		),
		"std" => "padding"),

	array("name" => "Constrain by padding",
		"desc" => " If you have constrained by padding above, enter the number of pixels here to pad the thumbs by",
		"id" => "smug_photos_constrain_by_padding",
		"grouping" => "smug-photos",
		"type" => "text",
		"hint" => "Enter the number of pixels here (don't enter 'px'). Non-integers will be ignored.",
		"std" => "15"),

	array("name" => "Constrain by number of thumbnails",
		"desc" => " If you have constrained by number of thumbnails per row above, enter the number of thumbnails",
		"id" => "smug_photos_constrain_by_count",
		"grouping" => "smug-photos",
		'type' => 'select',
		'options' => photonic_selection_range(1, 25),
		"std" => 5),

	array("name" => "Photo Thumbnail Border",
		"id" => "smug_photo_thumb_border",
		"grouping" => "smug-photos",
		"type" => 'border',
		"options" => array(),
		"std" => photonic_default_border(),
	),

	array("name" => "Photo Thumbnail - Padding between border and image",
		"desc" => "Setup the padding between the photo thumbnail and its border.",
		"id" => "smug_photo_thumb_padding",
		"grouping" => "smug-photos",
		'type' => 'padding',
		'options' => array(),
		'std' => photonic_default_padding(),
	),

	array("name" => "Photos (Popup Panel)",
		"desc" => "Control settings for SmugMug Photos when displayed in a popup",
		"category" => "smug-photos-pop",
		"type" => "section",),

	array("name" => "What is this section?",
		"desc" => "Options in this section are in effect when you use the shortcode format <code>[gallery type='smugmug' nick_name='abc' view='albums']</code>, and you click on an album thumbnail to open its photos in an overlaid panel.",
		"grouping" => "smug-photos-pop",
		"type" => "blurb",),

	array("name" => "Photo Title Display",
		"desc" => "How do you want the title of the photos?",
		"id" => "smug_photo_pop_title_display",
		"grouping" => "smug-photos-pop",
		"type" => "radio",
		"options" => photonic_title_styles(),
		"std" => "tooltip"),

	array("name" => "Constrain Photos Per Row",
		"desc" => "How do you want the control the number of photo thumbnails per row by default? This can be overridden by adding the '<code>columns</code>' parameter to the '<code>gallery</code>' shortcode.",
		"id" => "smug_photos_pop_per_row_constraint",
		"grouping" => "smug-photos-pop",
		"type" => "select",
		"options" => array("padding" => "Fix the padding around the thumbnails",
			"count" => "Fix the number of thumbnails per row",
		),
		"std" => "padding"),

	array("name" => "Constrain by padding",
		"desc" => " If you have constrained by padding above, enter the number of pixels here to pad the thumbs by",
		"id" => "smug_photos_pop_constrain_by_padding",
		"grouping" => "smug-photos-pop",
		"type" => "text",
		"hint" => "Enter the number of pixels here (don't enter 'px'). Non-integers will be ignored.",
		"std" => "15"),

	array("name" => "Constrain by number of thumbnails",
		"desc" => " If you have constrained by number of thumbnails per row above, enter the number of thumbnails",
		"id" => "smug_photos_pop_constrain_by_count",
		"grouping" => "smug-photos-pop",
		'type' => 'select',
		'options' => photonic_selection_range(1, 25),
		"std" => 5),

	array("name" => "Photo Thumbnail Border",
		"id" => "smug_photo_pop_thumb_border",
		"grouping" => "smug-photos-pop",
		"type" => 'border',
		"options" => array(),
		"std" => photonic_default_border(),
	),

	array("name" => "Photo Thumbnail - Padding between border and image",
		"desc" => "Setup the padding between the photo thumbnail and its border.",
		"id" => "smug_photo_pop_thumb_padding",
		"grouping" => "smug-photos-pop",
		'type' => 'padding',
		'options' => array(),
		'std' => photonic_default_padding(),
	),
);