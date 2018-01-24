<?php
/*
Plugin Name: Embed picasa album
Plugin URI: http://wordpress.org/
Description: Embed picasa album into post or page.
Author: Marchenko Alexandr
Version: 1.2.2
Author URI: http://mac-blog.org.ua/
*/

//http://www.presscoders.com/wordpress-settings-api-explained/

/////////////////////////////////////////////////////////////////////
//add plugin options page
add_action( 'admin_menu', 'embpicasa_admin_menu' );
function embpicasa_admin_menu() {
	add_options_page('Picasa settings', 'Picasa', 'manage_options', __FILE__, 'embpicasa_settings_page');
}
function embpicasa_settings_page() {
?>
	<div class="wrap">
		<div class="icon32" id="icon-options-general"><br></div>
		<h2>Picasa settings</h2>
		Enter auth params and select preferred image dimensions
		<form action="options.php" method="post">
		<?php settings_fields('embpicasa_options'); ?>
		<?php do_settings_sections(__FILE__); ?>
		<p class="submit">
			<input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
		</p>
		</form>
	</div>
<?php
}

/////////////////////////////////////////////////////////////////////
//register plugin options
add_action('admin_init', 'embpicasa_admin_init' );
function embpicasa_admin_init(){
	register_setting('embpicasa_options', 'embpicasa_options', 'embpicasa_options_validate' ); // group, name in db, validation func

	add_settings_section('auth_section', 'Auth Settings', 'embpicasa_options_section_auth', __FILE__);
	add_settings_field('embpicasa_options_login', 'Login', 'embpicasa_options_login_field_renderer', __FILE__, 'auth_section');
	add_settings_field('embpicasa_options_password', 'Password', 'embpicasa_options_password_field_renderer', __FILE__, 'auth_section');

	add_settings_section('img_section', 'Image Settings', 'embpicasa_options_section_img', __FILE__);
	add_settings_field('embpicasa_options_thumb_size', 'Thumbnail size', 'embpicasa_options_thumb_size_field_renderer', __FILE__, 'img_section');
	add_settings_field('embpicasa_options_thumb_crop', 'Crop thumbnail', 'embpicasa_options_thumb_crop_field_renderer', __FILE__, 'img_section');
	add_settings_field('embpicasa_options_full_size', 'Full image size', 'embpicasa_options_full_size_field_renderer', __FILE__, 'img_section');
	add_settings_field('embpicasa_options_full_crop', 'Crop full image', 'embpicasa_options_full_crop_field_renderer', __FILE__, 'img_section');
	add_settings_field('embpicasa_options_single_only', 'Show only on single post', 'embpicasa_options_single_only_field_renderer', __FILE__, 'img_section');
}

function embpicasa_options_section_auth() {
	echo '<p>Your login and password in picasa</p>';
}

function embpicasa_options_section_img() {
	echo '<p>Preferred image dimensions</p>';
}

function embpicasa_options_login_field_renderer() {
	$options = get_option('embpicasa_options');
	echo "<input id='embpicasa_options_login' name='embpicasa_options[embpicasa_options_login]' size='40' type='text' value='{$options['embpicasa_options_login']}' />";
}

function embpicasa_options_password_field_renderer() {
	$options = get_option('embpicasa_options');
	echo "<input id='embpicasa_options_password' name='embpicasa_options[embpicasa_options_password]' size='40' type='password' value='{$options['embpicasa_options_password']}' />";
}

function embpicasa_options_thumb_size_field_renderer() {
	$options = get_option('embpicasa_options');
	$items = array('32', '48', '64', '72', '104', '144', '150', '160');
	echo "<select id='embpicasa_options_thumb_size' name='embpicasa_options[embpicasa_options_thumb_size]'>";
	foreach($items as $item) {
		$selected = ($options['embpicasa_options_thumb_size']==$item) ? 'selected="selected"' : '';
		echo "<option value='$item' $selected>$item</option>";
	}
	echo "</select>";
}

function embpicasa_options_full_size_field_renderer() {
	$options = get_option('embpicasa_options');
	$items = array('94', '110', '128', '200', '220', '288', '320', '400', '512', '576', '640', '720', '800', '912', '1024', '1152', '1280', '1440', '1600');
	echo "<select id='embpicasa_options_full_size' name='embpicasa_options[embpicasa_options_full_size]'>";
	foreach($items as $item) {
		$selected = ($options['embpicasa_options_full_size']==$item) ? 'selected="selected"' : '';
		echo "<option value='$item' $selected>$item</option>";
	}
	echo "</select>";
}

function embpicasa_options_thumb_crop_field_renderer() {
	$options = get_option('embpicasa_options');
	$items = array('no', 'yes');
	echo "<select id='embpicasa_options_thumb_crop' name='embpicasa_options[embpicasa_options_thumb_crop]'>";
	foreach($items as $item) {
		$selected = ($options['embpicasa_options_thumb_crop']==$item) ? 'selected="selected"' : '';
		echo "<option value='$item' $selected>$item</option>";
	}
	echo "</select>";
}

function embpicasa_options_full_crop_field_renderer() {
	$options = get_option('embpicasa_options');
	$items = array('no', 'yes');
	echo "<select id='embpicasa_options_full_crop' name='embpicasa_options[embpicasa_options_full_crop]'>";
	foreach($items as $item) {
		$selected = ($options['embpicasa_options_full_crop']==$item) ? 'selected="selected"' : '';
		echo "<option value='$item' $selected>$item</option>";
	}
	echo "</select>";
}

function embpicasa_options_single_only_field_renderer() {
	$options = get_option('embpicasa_options');
	$items = array('no', 'yes');
	echo "<select id='embpicasa_options_single_only' name='embpicasa_options[embpicasa_options_single_only]'>";
	foreach($items as $item) {
		$selected = ($options['embpicasa_options_single_only']==$item) ? 'selected="selected"' : '';
		echo "<option value='$item' $selected>$item</option>";
	}
	echo "</select>";
}

function embpicasa_options_validate($input) {
	// strip all fields
	$input['embpicasa_options_login'] 	   =  wp_filter_nohtml_kses($input['embpicasa_options_login']);
	$input['embpicasa_options_password']   =  wp_filter_nohtml_kses($input['embpicasa_options_password']);
	$input['embpicasa_options_thumb_size'] =  wp_filter_nohtml_kses($input['embpicasa_options_thumb_size']);
	$input['embpicasa_options_full_size']  =  wp_filter_nohtml_kses($input['embpicasa_options_full_size']);

	// check image dimensions
	$items = array('32', '48', '64', '72', '104', '144', '150', '160');
	if(!in_array($input['embpicasa_options_thumb_size'], $items)) {
		$input['embpicasa_options_thumb_size'] = '150';
	}

	$items = array('94', '110', '128', '200', '220', '288', '320', '400', '512', '576', '640', '720', '800', '912', '1024', '1152', '1280', '1440', '1600');
	if(!in_array($input['embpicasa_options_full_size'], $items)) {
		$input['embpicasa_options_full_size'] = '640';
	}

	return $input;
}

// Define default option settings
register_activation_hook(__FILE__, 'embpicasa_options_add_defaults');
function embpicasa_options_add_defaults() {
    update_option('embpicasa_options', array(
		'embpicasa_options_login' 	   => 'LOGIN@gmail.com',
		'embpicasa_options_password'   => '',
		'embpicasa_options_thumb_size' => '150',
		'embpicasa_options_thumb_crop' => 'yes',
		'embpicasa_options_full_size'  => '640',
		'embpicasa_options_full_crop'  => 'no',
		'embpicasa_options_single_only'=> 'no'
	));
}



/////////////////////////////////////////////////////////////////////
// add the shortcode handler for picasa galleries
// http://brettterpstra.com/adding-a-tinymce-button/
function add_embpicasa_shortcode($atts, $content = null) {
        extract(shortcode_atts(array( "id" => '' ), $atts));

        // do not display anything if there is no "id"
		if(empty($id)) return '';

		$options = get_option('embpicasa_options');

		// do not display anything in loop if "Show only on single post"
		if(!is_single() && $options['embpicasa_options_single_only'] == 'yes') return '';

		if(!empty($options['embpicasa_options_login']) && !empty($options['embpicasa_options_password'])) {
			try {
				/*set_include_path(implode(PATH_SEPARATOR, array(
					realpath(dirname(__FILE__) . '/library'),
					get_include_path(),
				)));

				require_once 'Zend/Loader.php';

				Zend_Loader::loadClass('Zend_Gdata');
				Zend_Loader::loadClass('Zend_Gdata_Query');
				Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
				Zend_Loader::loadClass('Zend_Gdata_Photos');
				Zend_Loader::loadClass('Zend_Gdata_Photos_UserQuery');
				Zend_Loader::loadClass('Zend_Gdata_Photos_AlbumQuery');
				Zend_Loader::loadClass('Zend_Gdata_Photos_PhotoQuery');

				$client = Zend_Gdata_ClientLogin::getHttpClient($options['embpicasa_options_login'], $options['embpicasa_options_password'], Zend_Gdata_Photos::AUTH_SERVICE_NAME);
				$service = new Zend_Gdata_Photos($client);

				$photos = array();
				$query = new Zend_Gdata_Photos_AlbumQuery();
				$query->setAlbumId($id);
				// http://code.google.com/intl/ru/apis/picasaweb/docs/1.0/reference.html
				$thumb_suffix = $options['embpicasa_options_thumb_crop'] == 'no' ? 'u' : 'c';
				$full_suffix = $options['embpicasa_options_full_crop'] == 'no' ? 'u' : 'c';
				$query->setThumbsize($options['embpicasa_options_thumb_size'] . $thumb_suffix);
				$query->setImgMax($options['embpicasa_options_full_size'] . $full_suffix);
				$results = $service->getAlbumFeed($query);
				while($results != null) {
					foreach($results as $entry) {
						foreach($results as $photo) {
							$photos[] = array(
								'thumbnail' => $photo->mediaGroup->thumbnail[0]->url,
								'fullsize' => $photo->mediaGroup->content[0]->url,
								'title' => $photo->mediaGroup->description->text,
							);
						}
					}
					try {
						$results = $results->getNextFeed();
					}
					catch(Exception $e) {$results = null;}
				}*/

                $mail = $options['embpicasa_options_login'];
                $username = $mail;//substr($mail, 0, strpos($mail, '@'));

                $thumb_suffix = $options['embpicasa_options_thumb_crop'] == 'no' ? 'u' : 'c';
                $full_suffix = $options['embpicasa_options_full_crop'] == 'no' ? 'u' : 'c';
                $thumbsize = $options['embpicasa_options_thumb_size'] . $thumb_suffix;
                $imgmax = $options['embpicasa_options_full_size'] . $full_suffix;

                $album_url = 'https://picasaweb.google.com/data/feed/api/user/' . $username . '/albumid/' . $id . '?kind=photo&thumbsize=' . $thumbsize . '&imgmax=' . $imgmax;
                $xml = file_get_contents($album_url);
                $feed = new SimpleXMLElement($xml);
                $photos = array();
                foreach($feed->entry as $entry) {
                    $group = $entry->children('http://search.yahoo.com/mrss/')->group;

                    $photos[] = array(
                        'thumbnail' => strval($group->thumbnail->attributes()->url),
                        'fullsize' => strval($group->content->attributes()->url),
                        'title' => strval($group->title),
                    );
                }

				$plugin_template = dirname(__FILE__) . '/loop-picasa.php';
				$theme_template = get_theme_root() . '/' . get_stylesheet() . '/loop-picasa.php';
        		$template_path = file_exists($theme_template) ? $theme_template : $plugin_template;

				ob_start();
				include $template_path;
				$html = ob_get_contents();
				ob_end_clean();

				return $html;

			} catch(Exception $ex) {
				return '<p style="color:red">' . $ex->getMessage() . '</p>';
			}
		} else {
			return ''; //empty login or password
		}
}
add_shortcode('embpicasa', 'add_embpicasa_shortcode');

/////////////////////////////////////////////////////////////////////
// embed some javascript for tinymce plugin

// add jquery ui styles
function embpicasa_init() {
	if(is_admin() && current_user_can('edit_posts') && current_user_can('edit_pages') && get_user_option('rich_editing') == 'true') {
		wp_enqueue_script('jquery-ui-dialog');
		wp_enqueue_style('wp-jquery-ui-dialog');
	}

	if(!is_admin()) {
		wp_register_style( 'embpicasa-style', plugins_url('embpicasa.css', __FILE__));
		wp_enqueue_style( 'embpicasa-style' );
	}
}
add_action( 'init', 'embpicasa_init' );


add_action( 'edit_form_advanced', 'embpicasa_embed_js' );
add_action( 'edit_page_form', 'embpicasa_embed_js' );
function embpicasa_embed_js() {
?>
<script type="text/javascript">
	function embpicasa_dlg_open() {
		embpicasa_dlg_close();

		jQuery("#embpicasa_dlg").dialog({
			dialogClass: 'wp-dialog',
			modal: true,
			draggable: false,
			resizable: false,
			closeOnEscape: true,
			buttons: {'Insert': embpicasa_dlg_insert}/*,
			create:function () {
				jQuery(this).closest(".ui-dialog").find(".ui-button").addClass("button");
			}*/
		});

		jQuery("#embpicasa_dlg").dialog("open");
	}

	function embpicasa_dlg_insert() {
		var album_id = jQuery("#embpicasa_dlg_content_album").val();

		var shortcode = '[embpicasa id="'+album_id+'"]';

		if ( typeof tinyMCE != 'undefined' && ( ed = tinyMCE.activeEditor ) && !ed.isHidden() ) {
			ed.focus();
			if (tinymce.isIE)
				ed.selection.moveToBookmark(tinymce.EditorManager.activeEditor.windowManager.bookmark);

			ed.execCommand('mceInsertContent', false, shortcode);
		} else
			edInsertContent(edCanvas, shortcode);

		embpicasa_dlg_close();
	}

	function embpicasa_dlg_close() {
		if(jQuery("#embpicasa_dlg:visible").size() > 0) jQuery("#embpicasa_dlg").dialog("close");
	}
</script>

<?php
}


function embpicasa_js_dlg_markup() {
$options = get_option('embpicasa_options');
$success = true;
$msg = '';
$opts = '';

if(!empty($options['embpicasa_options_login']) && !empty($options['embpicasa_options_password'])) {
	try {
		/*set_include_path(implode(PATH_SEPARATOR, array(
			realpath(dirname(__FILE__) . '/library'),
			get_include_path(),
		)));

		require_once 'Zend/Loader.php';

		Zend_Loader::loadClass('Zend_Gdata');
		Zend_Loader::loadClass('Zend_Gdata_Query');
		Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
		Zend_Loader::loadClass('Zend_Gdata_Photos');
		Zend_Loader::loadClass('Zend_Gdata_Photos_UserQuery');
		Zend_Loader::loadClass('Zend_Gdata_Photos_AlbumQuery');
		Zend_Loader::loadClass('Zend_Gdata_Photos_PhotoQuery');

		$client = Zend_Gdata_ClientLogin::getHttpClient($options['embpicasa_options_login'], $options['embpicasa_options_password'], Zend_Gdata_Photos::AUTH_SERVICE_NAME);
		$service = new Zend_Gdata_Photos($client);

		$albums = array();

		$results = $service->getUserFeed();
		while($results != null) {
			foreach($results as $entry) {
				$album_id = $entry->gphotoId->text;
				$album_name = $entry->title->text;

				$albums[] = array(
					'id' => $album_id,
					'name' => $album_name
				);
			}

			try {
				$results = $results->getNextFeed();
			}
			catch(Exception $e) {$results = null;}
		}*/

        $mail = $options['embpicasa_options_login'];
        $username = $mail; //substr($mail, 0, strpos($mail, '@'));

        $feed = new SimpleXMLElement(file_get_contents('https://picasaweb.google.com/data/feed/api/user/' . $username . '?kind=album'));
        $albums = array();
        foreach($feed->entry as $entry) {
            $photoElements = $entry->children('http://schemas.google.com/photos/2007');

            $albums[] = array(
                'id' => strval($photoElements->id),
                'name' => strval($photoElements->name)
            );
        }

		foreach($albums as $album) {
			$opts = $opts . '<option value="' . $album['id'] . '">' . $album['name'] . '</option>';
		}

	} catch(Exception $ex) {
		$success = false;
		$msg = $ex->getMessage();
	}
}
?>
<div class="hidden">
	<div id="embpicasa_dlg" title="Picasa">
		<div class="embpicasa_dlg_content" style="padding:0 1em">
			<?php if($success):?>
				<p>
					<label>Select album:</label>
				</p>
				<p>
					<select id="embpicasa_dlg_content_album" style="width:100%"><?php echo $opts;?></select>
				</p>
			<?php else:?>
				<div style="padding:1em;" class="ui-state-error ui-corner-all">
					<p><strong>ERROR</strong><br /><?php echo $msg?></p>
				</div>
			<?php endif;?>
		</div>
	</div>
</div>
<style type="text/css">
.ui-button-text-only .ui-button-text {padding:0;}
.ui-widget-overlay {background:#AAAAAA;}
</style>
<?php
}
add_action( 'admin_footer', 'embpicasa_js_dlg_markup' );


/////////////////////////////////////////////////////////////////////
// add embpicasa button into tinymce
// http://brettterpstra.com/adding-a-tinymce-button/
function add_embpicasa_button() {
   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
     return;
   if ( get_user_option('rich_editing') == 'true') {
     add_filter('mce_external_plugins', 'add_embpicasa_tinymce_plugin');
     add_filter('mce_buttons', 'register_embpicasa_button');
   }
}
add_action('init', 'add_embpicasa_button');

function register_embpicasa_button($buttons) {
   array_push($buttons, "|", "embpicasa");
   return $buttons;
}

function add_embpicasa_tinymce_plugin($plugin_array) {
   $plugin_array['embpicasa'] = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)) . 'embpicasa.js';
   return $plugin_array;
}

// Trick/hack to tinymce refresh all files
function embpicasa_refresh_mce($ver) {
  $ver += 3;
  return $ver;
} add_filter( 'tiny_mce_version', 'embpicasa_refresh_mce');
