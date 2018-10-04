<?php

class Photonic_Flow_Manager {
	var $field_list, $error_mandatory, $error_no_response, $error_unknown, $error_not_found, $display_types;
	function __construct($plugin_dir) {
		global $photonic_flow_options;
		require_once(trailingslashit($plugin_dir)."admin/flow-fields.php");
		$this->field_list = $photonic_flow_options;

		$this->error_mandatory = __('Please fill the mandatory fields', 'photonic');
		$this->error_no_response = __('No response from server.', 'photonic');
		$this->error_unknown = __('Unknown error. Please post a <a href="https://wordpress.org/support/plugin/photonic/">support request</a>.', 'photonic');
		$this->error_not_found = __('Not found.', 'photonic');
		$this->error_no_data_returned = __('Not data was returned for the user you provided. Please verify that the user has the content you are looking for.', 'photonic');
		$this->error_not_permitted = __('Incorrect value passed for "%1$s": %2$s', 'photonic');

		$this->display_types = array(
			'single-photo' => 0,
			'multi-photo' => 1,
			'album-photo' => 1,
			'gallery-photo' => 1,
			'multi-album' => 2,
			'multi-gallery' => 2,
			'collection' => 3,
		);
	}

	function get_screen() {
		$screen = isset($_POST['screen']) ? sanitize_text_field($_POST['screen']) : 0;
		$provider = isset($_POST['provider']) ? sanitize_text_field($_POST['provider']) : '';
		$display_type = isset($_POST['display_type']) ? sanitize_text_field($_POST['display_type']) : '';

		$output = $this->validate($screen, $provider);
		if (!empty($output['error'])) {
			return '<div class="photonic-flow-error">'.$output['error']."</div>\n";
		}

		$screen = ((int)$screen) + 1;
		$screen_fields = $this->field_list['screen-'.$screen];
		$ret = '';

		if ($screen == 2 || $screen == '2') {
			$fields = $screen_fields[$provider]['display'];
			foreach ($fields as $id => $field) {
				if (!empty($field['type']) && $field['type'] == 'field_list') {
					$ret .= $this->process_field_list($id, $field);
				}
				else if (!empty($field['type'])) {
					$ret .= $this->process_field($id, $field, 0);
				}
			}
		}
		else if ($screen == 3) {
			$fields = $screen_fields[$provider][$display_type]['display'];
			foreach ($fields as $id => $field) {
				if (!empty($field['type']) && $field['type'] == 'field_list') {
					$ret .= $this->process_field_list($id, $field);
				}
				else if (!empty($field['type'])) {
					$ret .= $this->process_field($id, $field, 0);
				}
			}

			$ret = (empty($screen_fields[$provider][$display_type]['header']) ? '' : "<h1>".$screen_fields[$provider][$display_type]['header']."</h1>\n").
				(empty($screen_fields[$provider][$display_type]['desc']) ? '' : "<p>".$screen_fields[$provider][$display_type]['desc']."</p>\n").
				str_replace('{{placeholder_value}}', $output['success'], $ret);
		}
		else if ($screen == 4) {
			return $output['success'];
		}
		else {
			return $output['success'];
		}
		return $ret;
	}

	function validate($screen, $provider) {
		if (empty($screen) || !is_numeric($screen) || (is_numeric($screen) && (intval($screen) <= 0 || intval($screen) > 5 ))) {
			return array('error' => sprintf(__('Invalid screen value: %s', 'photonic'), $screen));
		}
		if (!in_array($provider, array('wp', 'flickr', 'picasa', 'smugmug', '500px', 'zenfolio', 'instagram'))) {
			return array('error' => sprintf(__('Invalid photo provider: %s', 'photonic'), $provider));
		}

		$screen = intval($screen);
		$display_type = isset($_POST['display_type']) ? sanitize_text_field($_POST['display_type']) : '';
		if ($screen > 1 && !in_array($display_type, array_keys($this->display_types))) {
			return array('error' => sprintf(__('Invalid display type: %s', 'photonic'), $display_type));
		}

		if ($screen == 1) {
			switch ($provider) {
				case 'flickr':
					global $photonic_flickr_api_key, $photonic_flickr_api_secret;
					if (empty($photonic_flickr_api_key) || empty($photonic_flickr_api_secret)) {
						return array('error' => __('Please set up your Flickr API key and secret under <em>Photonic &rarr; Settings &rarr; Flickr &rarr; Flickr Settings</em>', 'photonic'));
					}
					break;

				case 'picasa':
					global $photonic_picasa_client_id, $photonic_picasa_client_secret, $photonic_picasa_refresh_token;
					if (empty($photonic_picasa_client_id) || empty($photonic_picasa_client_secret)) {
						return array('error' => __('Please set up your Picasa Client ID and secret under <em>Photonic &rarr; Settings &rarr; Picasa &rarr; Picasa Settings</em>', 'photonic'));
					}
					else if (empty($photonic_picasa_refresh_token)) {
						return array('error' => __('Please set up your Picasa Authentication from <em>Photonic &rarr; Authentication</em>', 'photonic'));
					}
					break;

				case '500px':
					break;

				case 'smugmug':
					break;

				case 'instagram':
					break;

				default:	// wp, zenfolio
					return '';
			}
		}
		else if ($screen == 2) {
			$screen_fields = $this->field_list['screen-'.$screen];
			$fields = $screen_fields[$provider]['display'];
			$flattened_fields = array();
			foreach ($fields as $field) {
				if (!empty($field['type']) && $field['type'] != 'field_list') {
					$flattened_fields[] = $field;
				}
				else if (!empty($field['type']) && $field['type'] == 'field_list') {
					$flattened_fields = array_merge($field['list'], $flattened_fields);
				}
			}

			switch ($provider) {
				case 'flickr':
					$for = sanitize_text_field($_POST['for']);
					if (empty($display_type) || empty($for)) {
						return array('error' => $this->error_mandatory);
					}

					if (!in_array($display_type, array_keys($flattened_fields['display_type']['options']))) {
						return array('error' => sprintf(__('Invalid display type: %s', 'photonic'), $display_type));
					}

					if ($display_type != 'multi-photo' && in_array($for, array('group', 'any'))) {
						$err = __('Incompatible selections:', 'photonic')."<br/>\n";
						$err .= $flattened_fields['display_type']['desc'].": ".$flattened_fields['display_type']['options'][$display_type]."<br/>\n";
						$err .= $flattened_fields['for']['desc'].": ".$flattened_fields['for']['options'][$for]."<br/>\n";
						return array('error' => $err);
					}

					$group = sanitize_text_field($_POST['group']);
					$login = sanitize_text_field($_POST['login']);
					global $photonic_flickr_default_user, $photonic_flickr_api_key;
					if ($for == 'current' && empty($photonic_flickr_default_user)) {
						return array('error' => __('Default user not defined under <em>Photonic &rarr; Settings &rarr; Flickr &rarr; Flickr Settings &rarr; Default User</em>. <br/>Select "Another user" and put in your user id.', 'photonic'));
					}

					if (($for == 'group' && empty($group)) || ($for == 'other' && empty($login))) {
						return array('error' => $this->error_mandatory);
					}

					$parameters = array();
					$user = $for == 'current' ? $photonic_flickr_default_user : ($for == 'other' ? $login : '');
					if (($for == 'other' || $for == 'current') && !empty($user)) {
						$url = 'https://api.flickr.com/services/rest/?format=json&nojsoncallback=1&api_key='.$photonic_flickr_api_key.'&method=flickr.urls.lookupUser&url='.urlencode('https://www.flickr.com/photos/').$user;
						$response = $this->execute_query('flickr', $url, 'flickr.urls.lookupUser');
						if (!empty($response['error'])) {
							// Maybe the user provided the full URL instead of just the user name?
							$url = 'https://api.flickr.com/services/rest/?format=json&nojsoncallback=1&api_key='.$photonic_flickr_api_key.'&method=flickr.urls.lookupUser&url='.urlencode($user);
							$response = $this->execute_query('flickr', $url, 'flickr.urls.lookupUser');
							if (!empty($response['error'])) {
								return $response;
							}
							$parameters = array_merge($response['success'], $parameters);
						}
						else {
							$parameters = array_merge($response['success'], $parameters);
						}
					}

					if ($for == 'group' && !empty($group)) {
						$url = 'https://api.flickr.com/services/rest/?format=json&nojsoncallback=1&api_key='.$photonic_flickr_api_key.'&method=flickr.urls.lookupGroup&url='.urlencode('https://www.flickr.com/groups/').$group;
						$response = $this->execute_query('flickr', $url, 'flickr.urls.lookupGroup');
						if (!empty($response['error'])) {
							// Maybe the user provided the full URL instead of just the group name?
							$url = 'https://api.flickr.com/services/rest/?format=json&nojsoncallback=1&api_key='.$photonic_flickr_api_key.'&method=flickr.urls.lookupGroup&url='.urlencode($user);
							$response = $this->execute_query('flickr', $url, 'flickr.urls.lookupGroup');
							if (!empty($response['error'])) {
								return $response;
							}
							$parameters = array_merge($response['success'], $parameters);
						}
						else {
							$parameters = array_merge($response['success'], $parameters);
						}
					}

					// All OK so far. Let's try to get the data for the next screen
					$parameters['api_key'] = $photonic_flickr_api_key;
					$parameters['format'] = 'json';
					$parameters['nojsoncallback'] = 1;

					if ($display_type == 'single-photo') {
						$parameters['view'] = 'photo';
						$parameters['method'] = 'flickr.photos.search';
					}
					else if ($display_type == 'multi-photo') {
						$parameters['view'] = 'photos';
						$parameters['method'] = 'flickr.photos.search';
					}
					else if ($display_type == 'multi-album' || $display_type == 'album-photo') {
						$parameters['view'] = 'photosets';
						$parameters['method'] = 'flickr.photosets.getList';
					}
					else if ($display_type == 'multi-gallery' || $display_type == 'gallery-photo') {
						$parameters['view'] = 'galleries';
						$parameters['method'] = 'flickr.galleries.getList';
					}
					else if ($display_type == 'collection') {
						$parameters['view'] = 'collections';
						$parameters['method'] = 'flickr.collections.getTree';
					}

					$url = add_query_arg($parameters, 'https://api.flickr.com/services/rest/');
					$response = wp_remote_request($url, array('sslverify' => false));
					if (!is_wp_error($response)) {
						if (isset($response['response']) && isset($response['response']['code'])) {
							if ($response['response']['code'] == 200) {
								if (isset($response['body'])) {
									$objects = array();
									$body = json_decode($response['body']);
									if (isset($body->photosets) && isset($body->photosets->photoset)) {
										$photosets = $body->photosets->photoset;
										foreach ($photosets as $flickr_object) {
											$object = array();
											$object['id'] = $flickr_object->id;
											$object['title'] = esc_attr($flickr_object->title->_content);
											$object['counters'] = array();
											if (!empty($flickr_object->photos)) $object['counters'][] = sprintf(_n('%s photo', '%s photos', $flickr_object->photos, 'photonic'), $flickr_object->photos);
											if (!empty($flickr_object->videos)) $object['counters'][] = sprintf(_n('%s video', '%s videos', $flickr_object->videos, 'photonic'), $flickr_object->videos);
											$object['thumbnail'] = "https://farm".$flickr_object->farm.".static.flickr.com/".$flickr_object->server."/".$flickr_object->primary."_".$flickr_object->secret."_q.jpg";
											$objects[] = $object;
										}
									}
									else if (isset($body->galleries) && isset($body->galleries->gallery)) {
										$galleries = $body->galleries->gallery;
										foreach ($galleries as $flickr_object) {
											$object = array();
											$object['id'] = $flickr_object->id;
											$object['title'] = esc_attr($flickr_object->title->_content);
											$object['counters'] = array();
											if (!empty($flickr_object->count_photos)) $object['counters'][] = sprintf(_n('%s photo', '%s photos', $flickr_object->count_photos, 'photonic'), $flickr_object->count_photos);
											if (!empty($flickr_object->count_videos)) $object['counters'][] = sprintf(_n('%s video', '%s videos', $flickr_object->count_videos, 'photonic'), $flickr_object->count_videos);
											$object['thumbnail'] = "https://farm".$flickr_object->primary_photo_farm.".static.flickr.com/".$flickr_object->primary_photo_server."/".$flickr_object->primary_photo_id."_".$flickr_object->primary_photo_secret."_q.jpg";
											$objects[] = $object;
										}
									}
									else if (isset($body->photos) && isset($body->photos->photo)) {
										$photos = $body->photos->photo;
										foreach ($photos as $flickr_object) {
											$object = array();
											$object['id'] = $flickr_object->id;
											$object['title'] = esc_attr($flickr_object->title);
											$object['thumbnail'] = 'https://farm'.$flickr_object->farm.'.static.flickr.com/'.$flickr_object->server.'/'.$flickr_object->id.'_'.$flickr_object->secret.'_q.jpg';
											$objects[] = $object;
										}
									}
									else if (isset($body->collections) && isset($body->collections->collection)) {
										$collections = $body->collections->collection;
										foreach ($collections as $flickr_object) {
											$object = array();
											$object['id'] = $flickr_object->id;
											$object['title'] = esc_attr($flickr_object->title);
											$object['counters'] = array();
											if (!empty($flickr_object->set)) $object['counters'][] = sprintf(_n('%s album', '%s albums', count($flickr_object->set), 'photonic'), count($flickr_object->set));
											$object['thumbnail'] = $flickr_object->iconlarge;
											$objects[] = $object;
										}
									}

									if (empty($objects)) {
										return array('error' => $this->error_no_data_returned);
									}

									$output = '';
									foreach ($objects as $object) {
										$title = !empty($object['title']) ? $object['title'].'<br/>' : '';
										$counts = !empty($object['counters']) ? implode(', ', $object['counters']) : '';
										$output .= "<div class='photonic-flow-selector'>\n";
										$output .= "\t<div class='photonic-flow-selector-inner' data-photonic-selection-id='{$object['id']}'>\n";
										$output .= "\t\t<img src='{$object['thumbnail']}' alt='{$object['title']}' />\n";
										$output .= "\t\t<div class='photonic-flow-selector-info'>".$title.$counts."</div>\n";
										$output .= "\t</div>\n";
										$output .= "</div>\n";
									}

									if (!empty($parameters['user_id'])) {
										$output .= "<input type='hidden' name='user_id' value='{$parameters['user_id']}'/>";
									}
									else if (!empty($parameters['group_id'])) {
										$output .= "<input type='hidden' name='group_id' value='{$parameters['group_id']}'/>";
									}
									return array('success' => $output);
								}
							}
						}
					}
					break;

				case 'picasa':
					break;

				case '500px':
					break;

				case 'smugmug':
					break;

				case 'instagram':
					break;

				default:	// wp, zenfolio
					return '';
			}
		}
		else if ($screen == 3) {
			//Check for display_type
			$screen_fields = $this->field_list['screen-'.$screen];
			$provider_fields = $screen_fields[$provider];
			$fields = $provider_fields[$display_type]['display'];
			foreach ($fields as $id => $field) {
				$checks = $this->do_basic_option_check($id, $field, true);
				if (!empty($checks)) {
					return $checks;
				}

				if ($id == 'selection' && sanitize_text_field($_POST['selection']) == 'selected' &&  empty($_POST['selected_data'])) {
					return array('error' => __('Please select what you want to show.', 'photonic'));
				}
			}

			// All OK? Get next screen
			$output = $this->get_layout_selector($display_type);
			return array('success' => $output);
		}
		else if ($screen == 4) {
			$layout = isset($_POST['layout']) ? sanitize_text_field($_POST['layout']) : '';
			if (empty($layout)) {
				return array('error' => $this->error_mandatory);
			}
			global $photonic_flow_layout_options;
			if (!array_key_exists($layout, $photonic_flow_layout_options)) {
				return array('error' => sprintf(__('Invalid layout: %s', 'photonic'), $layout));
			}

			// All good. Next screen:
			return array('success' => $this->get_layout_options($provider, $display_type, $layout));
		}
		else {
			return array('success' => $this->build_shortcode());
		}
		return '';
	}

	function process_field_list($field_list_name, $field_list) {
		if (!is_array($field_list) || empty($field_list['type']) || $field_list['type'] != 'field_list' || empty($field_list['list'])) {
			return '';
		}
		else {
			$ret = '';
			$counter = 0;
			$sequence_group = null;
			foreach ($field_list['list'] as $id => $field) {
				if ($field_list['list_type'] == 'sequence') {
					$counter++;
					$sequence_group = $field_list_name;
				}
				$ret .= $this->process_field($id, $field, $counter, $sequence_group);
			}
			return $ret;
		}
	}

	function process_field($id, $field, $sequence, $sequence_group = null) {
		if (!is_array($field) || empty($field['type'])) {
			return '';
		}

		$req = empty($field['req']) ? '' : ' * ';
		switch ($field['type']) {
			case 'text':
				$ret = "<label class='photonic-flow-option-name'>{$field['desc']}$req<input type='text' name='{$id}' value='".(isset($field['std']) ? $field['std'] : '')."'/></label>";
				break;

			case 'radio':
				$ret = !empty($field['desc']) ? '<div class="photonic-flow-option-name">'.$field['desc'].$req.'</div>' : '';
				$default = isset($field['std']) ? $field['std'] : '';
				foreach ($field['options'] as $option_value => $option_description) {
					$option_condition = (empty($field['option-conditions']) || empty($field['option-conditions'][$option_value])) ? '' :
						"data-photonic-option-condition='".json_encode($field['option-conditions'][$option_value])."'";
					$checked = checked($default, $option_description, false);
					$ret .= "\t<div class='photonic-flow-field-radio'><label><input type='radio' name='{$id}' value='$option_value' $checked $option_condition/>".$option_description."</label></div>\n";
				}
				break;

			case 'select':
				$ret = "<label class='photonic-flow-option-name'>{$field['desc']}$req\n\t<select name='{$id}'>\n";
				$default = isset($field['std']) ? $field['std'] : '';
				foreach ($field['options'] as $option_value => $option_description) {
					$option_condition = (empty($field['option-conditions']) || empty($field['option-conditions'][$option_value])) ? '' :
						"data-photonic-option-condition='".json_encode($field['option-conditions'][$option_value])."'";
					$selected = selected($default, $option_value, false);
					$ret .= "\t\t<option value='$option_value' $selected $option_condition>".esc_attr($option_description)."</option>\n";
				}
				$ret .= "\t</select>\n</label>\n";
				break;

			case 'image-select':
				$ret = '';
				$ret .= '<div class="photonic-flow-option-name">'.$field['desc'].'</div>';
				if (isset($field['std'])) {
					$selection = !in_array($field['std'], $field['options']) ? array_keys($field['options'])[0] : $field['std'];
				}
				else {
					$selection = array_keys($field['options'])[0];
				}
				foreach ($field['options'] as $option_name => $desc) {
					$esc_desc = esc_attr($desc);
					$selected = ($option_name == $selection) ? 'selected' : '';
					$ret .= "<div class=\"photonic-flow-selector photonic-flow-$id-$option_name $selected\" title=\"$esc_desc\">\n\t<span class=\"photonic-flow-selector-inner photonic-$id\" data-photonic-selection-id=\"$option_name\">&nbsp;</span>\n\t<div class='photonic-flow-selector-info'>$desc</div>\n</div>\n";
				}
				if (!empty($ret)){
					$ret = "<div class='photonic-flow-selector-container photonic-flow-$id' data-photonic-flow-selector-mode='single-no-plus' data-photonic-flow-selector-for=\"$id\">\n<input type=\"hidden\" id=\"$id\" name=\"$id\" value='$selection'/>\n$ret</div>\n";
				}
				break;

			case 'multi-select':
				$ret = '';
				$ret .= '<div class="photonic-flow-option-name">'.$field['desc'].'</div>';
				if (isset($field['std'])) {
					$selection = explode(',', $field['std']);
				}
				else {
					$selection = array();
				}
				foreach ($field['options'] as $option_value => $desc) {
					$checked = in_array($option_value, $selection) ? 'checked' : '';
					$ret .= "\t<label class='photonic-multi-select-item'><input type='checkbox' name='{$id}[]' value=\"$option_value\" $checked />$desc</label>\n";
				}
				if (!empty($ret)){
					$ret = "<div class='photonic-flow-multi-select-container'>\n$ret</div>\n";
				}
				break;

			case 'placeholder':
				$ret = $field['markup'];
				break;

			default:
				return '';
		}

		if (!empty($ret)) {
			if (!empty($field['hint'])) {
				$ret .= "<div class='photonic-flow-hint'>{$field['hint']}</div>\n";
			}

			$sequence_str = '';
			if ($sequence !== 0) {
				$sequence_str = 'data-photonic-flow-sequence="'.$sequence.'"';
			}

			$sequence_group_str = '';
			if (!is_null($sequence_group)) {
				$sequence_group_str = 'data-photonic-flow-sequence-group="'.$sequence_group.'"';
			}

			$condition = '';
			if (!empty($field['conditions'])){
				$condition = "data-photonic-condition='".json_encode($field['conditions'])."'";
			}

			$ret = "<div class='photonic-flow-field' $sequence_str $condition $sequence_group_str>\n".$ret."</div>\n";
		}
		return $ret;
	}

	function execute_query($where, $url, $method) {
		$response = wp_remote_request($url, array('sslverify' => false));
		if (!is_wp_error($response)) {
			if (isset($response['response']) && isset($response['response']['code'])) {
				if ($response['response']['code'] == 200) {
					if (isset($response['body'])) {
						$body = json_decode($response['body']);
						if ($where == 'flickr') {
							if (isset($body->stat) && $body->stat == 'fail') {
								return array('error' => $body->message);
							}
							else {
								if ($method == 'flickr.urls.lookupUser') {
									if (isset($body->user)) {
										return array('success' => array('user_id' => $body->user->id));
									}
								}
								else if ($method == 'flickr.urls.lookupGroup') {
									if (isset($body->group)) {
										return array('success' => array('group_id' => $body->group->id));
									}
								}
								return array('error' => $this->error_not_found);
							}
						}
/*						else if ($where == 'instagram') {
							$this->execute_instagram_query($response['body'], $method);
						}
						else if ($where == 'zenfolio') {
							$this->execute_zenfolio_query($response['body'], $method);
						}*/
						else {
							return array('error' => $this->error_unknown);
						}
					}
					else {
						return array('error' => $this->error_no_response);
					}
				}
				else {
					return array('error' => $response['response']['message']);
				}
			}
			else {
				return array('error' => $this->error_no_response);
			}
		}
		else {
			return array('error' => $this->error_no_response);
		}
	}

	private function do_basic_option_check($id, $field, $check_required = false) {
		if (empty($field['type']) || ($field['type'] != 'select' && $field['type'] != 'radio')) {
			return false;
		}

		if ($check_required && !empty($field['req']) && (!isset($_POST[$id]) || empty(trim($_POST[$id])))) {
			return array('error' => $this->error_mandatory);
		}

		if (isset($_POST[$id]) && !in_array(sanitize_text_field($_POST[$id]), array_keys($field['options']))) {
			return array('error' => sprintf($this->error_not_permitted, $field['name'], $_POST[$id]));
		}
		return false;
	}

	private function get_layout_selector($display_type) {
		global $photonic_flow_layout_options, $photonic_thumbnail_style;
		$output = '';
		$level = empty($this->display_types[$display_type]) ? -1 : $this->display_types[$display_type];
		$layout_from_option = in_array($photonic_thumbnail_style, array('strip-below', 'strip-above', 'strip-right', 'no-strip')) ? 'slideshow' : $photonic_thumbnail_style;

		if ($level > 0) {
			foreach ($photonic_flow_layout_options as $layout => $desc) {
				$selected = $layout == $layout_from_option ? 'selected' : '';
				if (($layout == 'slideshow' && $level == 1) || $layout != 'slideshow') {
					$esc_desc = esc_attr($desc);
					$output .= "<div class=\"photonic-flow-selector photonic-flow-layout-$layout $selected\" title=\"$esc_desc\">\n\t<span class=\"photonic-flow-selector-inner photonic-layout\" data-photonic-selection-id=\"$layout\">&nbsp;</span>\n\t<div class='photonic-flow-selector-info'>$desc</div>\n</div>\n";
				}
			}
			if (!empty($output)){
				$output = "<div class='photonic-flow-selector-container photonic-flow-layout' data-photonic-flow-selector-mode='single-no-plus' data-photonic-flow-selector-for=\"layout\">\n<input type=\"hidden\" id=\"layout\" name=\"layout\" value='$layout_from_option'/>\n$output</div>\n";
			}
		}
		return '<h1>'.__('Pick Your Layout', 'photonic').'</h1>'.
			$output.
			"<div class='photonic-flow-hint'>".__('You can configure the default settings from <strong>Photonic &rarr; Settings &rarr; Generic Options &rarr; Generic Settings &rarr; Layouts</strong>.', 'photonic')."</div>\n";
	}

	private function get_layout_options($provider, $display_type, $layout) {
		// All levels, all layouts - media
		// L1, L2 All layouts - title position
		// L1 All layouts - count, more
		// L1, L2, L3 basic lightbox layouts - # of columns, constrain by etc., thumbnail size, full size
		// L3 Flickr - auto-expand
		$level = $this->display_types[$display_type];
		$output = '<h1>'.__('Configure Your Layout', 'photonic').'</h1>';

		if (!empty($this->field_list['screen-5'][$layout])) {
			$fields = $this->field_list['screen-5'][$layout];
			foreach ($fields as $id => $field) {
				if (!empty($field['type'])) {
					$output .= $this->process_field($id, $field, 0);
				}
			}
		}

		if (!empty($this->field_list['screen-5'][$provider]['L'.$level])) {
			$fields = $this->field_list['screen-5'][$provider]['L'.$level];
			foreach ($fields as $id => $field) {
				if (!empty($field['type'])) {
					$output .= $this->process_field($id, $field, 0);
				}
			}
		}

		if (!empty($this->field_list['screen-5']['L'.$level])) {
			$fields = $this->field_list['screen-5']['L'.$level];
			foreach ($fields as $id => $field) {
				if (!empty($field['type'])) {
					$output .= $this->process_field($id, $field, 0);
				}
			}
		}
		return $output;
	}

	private function build_shortcode() {
		global $photonic_alternative_shortcode, $photonic_flow_layout_options;
		$provider = $_POST['provider'];
		$short_code = array();
		$short_code['type'] = $provider;
		switch ($provider) {
			case 'flickr':
				if ($_POST['display_type'] == 'single-photo') {
					$short_code['view'] = 'photo';
					$short_code['photo_id'] = $_POST['selected_data'];
				}
				else if ($_POST['display_type'] == 'multi-photo') {
					$short_code['view'] = 'photos';
				}
				else if ($_POST['display_type'] == 'album-photo') {
					$short_code['view'] = 'photosets';
					$short_code['photoset_id'] = $_POST['selected_data'];
				}
				else if ($_POST['display_type'] == 'gallery-photo') {
					$short_code['view'] = 'galleries';
					$short_code['gallery_id'] = $_POST['selected_data'];
				}
				else if ($_POST['display_type'] == 'multi-album') {
					$short_code['view'] = 'photosets';
				}
				else if ($_POST['display_type'] == 'multi-gallery') {
					$short_code['view'] = 'galleries';
				}
				else if ($_POST['display_type'] == 'collection') {
					$short_code['view'] = 'collections';
					$short_code['collection_id'] = $_POST['selected_data'];
				}

				if (!empty($_POST['selected'])) {
					if ($_POST['selected'] != 'all') {
						$short_code['filter'] = $_POST['selected_data'];
					}
					if ($_POST['selected'] == 'not-selected') {
						$short_code['filter_type'] = 'exclude';
					}
				}

				if (!empty($_POST['layout'])) {
					if ($_POST['layout'] != 'slideshow') {
						$short_code['layout'] = $_POST['layout'];
					}
					else {
						$short_code['layout'] = $_POST['slideshow-style'];
					}
				}
				// layout

				$same_name_attrs = array(
					'user_id', 'group_id', 'collections_display', 'tags', 'tag_mode', 'text', 'sort', 'privacy_filter', // Flickr
					'count', 'more', 'title_position', 'caption', 'media', 'main_size', 'thumb_size', 'tile_size', 'video_size', 'popup', 'thumbnail_effect', 'headers', // All lightbox
					'speed', 'timeout', 'fx', 'pause', 'strip-style', 'controls',
				);
				foreach ($same_name_attrs as $attr) {
					if (!empty($_POST[$attr]) && is_array($_POST[$attr])) {
						$short_code[$attr] = implode($_POST[$attr], ',');
					}
					else if (!empty($_POST[$attr])) {
						$short_code[$attr] = $_POST[$attr];
					}
				}
				break;

			case 'picasa':
				break;

			case 'smugmug':
				break;

			case 'zenfolio':
				break;

			case 'instagram':
				break;

			case '500px':
				break;

			default:
				break;
		}

		$output = "<code>[".(empty($photonic_alternative_shortcode) ? 'gallery ' : $photonic_alternative_shortcode);
		$shortcode_attrs = array();
		foreach ($short_code as $attr => $value) {
			$shortcode_attrs[] = $attr."='".esc_attr($value)."'";
		}
		$output .= implode(' ', $shortcode_attrs);
		$output .= ']</code>';
		return $output;
	}
}
