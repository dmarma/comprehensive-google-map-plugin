<?php
/*
Copyright (C) 2011  Alexander Zagniotov

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
  
if ( !function_exists('cgmp_draw_map_placeholder') ):
		function cgmp_draw_map_placeholder($id, $width, $height, $align) {

			$toploading = ceil($height / 2) - 50;

	$result = '<div align="'.$align.'"><div class="google-map-placeholder" id="' .$id . '" style="width:' . 
			$width . 'px;height:' . $height . 'px; border:1px solid #333333;"><div class="loading" style="top: '.$toploading.'px !important;"></div></div>';

			$result .= '<div class="direction-controls-placeholder" id="direction-controls-placeholder-' .$id . '" style="width: '.$width.'px; margin-top: 5px; border: 1px solid #EBEBEB; display: none; padding: 18px 0 9px 0;">
			<div class="d_close-wrapper">
				<a id="d_close" href="javascript:void(0)"> 
					<img src="'.CGMP_PLUGIN_IMAGES.'/transparent.png" class="close"> 
				</a>
			</div>

			<div style="" id="travel_modes_div" class="dir-tm kd-buttonbar">
				<a tabindex="3" class="kd-button kd-button-left selected" href="javascript:void(0)" id="dir_d_btn" title="By car"> 
					<img class="dir-tm-d" src="'.CGMP_PLUGIN_IMAGES.'/transparent.png" /> 
				</a>
				<a tabindex="3" class="kd-button kd-button-right" href="javascript:void(0)" id="dir_w_btn" title="Walking"> 
					<img class="dir-tm-w" src="'.CGMP_PLUGIN_IMAGES.'/transparent.png"> 
				</a>
			</div>
			<div class="dir-clear"></div>
			<div id="dir_wps">
				<div id="dir_wp_0" class="dir-wp">
					<div class="dir-wp-hl">
						<div id="dir_m_0" class="dir-m" style="cursor: -moz-grab;">
							<div style="width: 24px; height: 24px; overflow: hidden; position: relative;">
								<img style="position: absolute; left: 0px; top: -141px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px;" src="'.CGMP_PLUGIN_IMAGES.'/directions.png">
							</div>
						</div>
						<div class="dir-input">
							<div class="kd-input-text-wrp">
								<input type="text" maxlength="2048" tabindex="4" value="" name="a_address" id="a_address" title="Start address" class="wp kd-input-text" autocomplete="off" autocorrect="off">
							</div>
						</div>
					</div>
				</div>
				<div class="dir-rev-wrapper">
					<div id="dir_rev" title="Get reverse directions">
						<a id="reverse-btn" href="javascript:void(0)" class="kd-button"> 
							<img class="dir-reverse" src="'.CGMP_PLUGIN_IMAGES.'/transparent.png"> 
						</a>
					</div>
				</div>
				<div id="dir_wp_1" class="dir-wp">
					<div class="dir-wp-hl">
						<div id="dir_m_1" class="dir-m" style="cursor: -moz-grab;">
							<div style="width: 24px; height: 24px; overflow: hidden; position: relative;">
								<img style="position: absolute; left: 0px; top: -72px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px;" src="'.CGMP_PLUGIN_IMAGES.'/directions.png">
							</div>
						</div>
						<div class="dir-input">
							<div class="kd-input-text-wrp">
								<input type="text" maxlength="2048" tabindex="4" value="" name="b_address" id="b_address" title="End address" class="wp kd-input-text" autocomplete="off" autocorrect="off">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="dir_controls">
				<div class="d_links">
					<span id="d_options_toggle">
						<a id="d_options_show" class="no-wrap" href="javascript:void(0)" style="display: none !important;">Show options</a> 
						<a id="d_options_hide" class="no-wrap" href="javascript:void(0)" style="display: none !important;">Hide options</a>
					   	<b><span style="color: blue">Additional options</span></b>
					</span>
				</div>
				<div id="d_options" style="background-color: #ddd; margin-bottom: 3px; text-align: left; padding: 3px;">
					<input type="checkbox" tabindex="5" name="avoid_hway" id="avoid_hway" />
					<label for="avoid_hway">Avoid highways</label>
					<input type="checkbox" tabindex="5" name="avoid_tolls" id="avoid_tolls" />
					<label for="avoid_tolls">Avoid tolls</label>
					<input type="radio" name="travel_mode" id="radio_km" />
					<label for="radio_km">KM</label>
					<input type="radio" name="travel_mode" id="radio_miles" checked="checked" />
					<label for="radio_miles">Miles</label>
				</div>
				<div class="dir-sub-cntn">
					<button tabindex="6" name="btnG" type="submit" id="d_sub" class="kd-button kd-button-submit">Get Directions</button>
					<button tabindex="6" name="btnG" type="button" style="display: none;" id="print_sub" class="kd-button kd-button-submit">Print Directions</button>
				</div>
			</div>
		</div>
		<div id="rendered-directions-placeholder-' .$id . '" style="display: none; border: 1px solid #ddd; width: '.($width - 10).'px; margin-top: 10px; direction: ltr; overflow: auto; height: 180px; padding: 5px;" class="rendered-directions-placeholder"></div>
	</div>';

        return $result;
 	}
endif;

if ( !function_exists('update_markerlist_from_legacy_locations') ):
	function update_markerlist_from_legacy_locations($latitude, $longitude, $addresscontent, $hiddenmarkers)  {

		$legacyLoc = isset($addresscontent) ? $addresscontent : "";

		if (isset($latitude) && isset($longitude)) {
			if ($latitude != "0" && $longitude != "0" && $latitude != 0 && $longitude != 0) {
				$legacyLoc = $latitude.",".$longitude;
			}
		}

		if (isset($hiddenmarkers) && $hiddenmarkers != "") {

			if (strpos($hiddenmarkers, CGMP_SEP) === false) {
				$hiddenmarkers = explode("|", $hiddenmarkers);
				$hiddenmarkers = implode(CGMP_SEP."1-default.png|", $hiddenmarkers);
				$hiddenmarkers = $hiddenmarkers.CGMP_SEP."1-default.png";
			}
		}

		if (trim($legacyLoc) != "")  {
			$hiddenmarkers = $legacyLoc.CGMP_SEP."1-default.png".(isset($hiddenmarkers) && $hiddenmarkers != "" ? "|".$hiddenmarkers : "");
		}

		return $hiddenmarkers;

	}
endif;

if ( !function_exists('cgmp_begin_map_init_v2') ):
	function cgmp_begin_map_init_v2($id, $zoom, $type, $bubbleAutoPan, $controlOpts) {
		$result =  '<script type="text/javascript">'.PHP_EOL;
		$result .= '    jQuery(document).ready(function() {'.PHP_EOL;
		$result .= '    var map_'.$id.' = new google.maps.Map(document.getElementById("'.$id.'"));'.PHP_EOL;
		$result .= '    var orc = new jQuery.GoogleMapOrchestrator(map_'.$id.', {bubbleAutoPan: "'.$bubbleAutoPan.'", zoom : '.$zoom.', mapType: google.maps.MapTypeId.'.$type.'});'.PHP_EOL;
		$result	.= '    orcHolder.push({mapId: "'.$id.'", orchestrator: orc});'.PHP_EOL;
		$result .= '    orc.switchMapControl('.$controlOpts['m_aptypecontrol'].', jQuery.GoogleMapOrchestrator.ControlType.MAPTYPE);'.PHP_EOL;
        $result .= '    orc.switchMapControl('.$controlOpts['pancontrol'].', jQuery.GoogleMapOrchestrator.ControlType.PAN);'.PHP_EOL;
        $result .= '    orc.switchMapControl('.$controlOpts['z_oomcontrol'].', jQuery.GoogleMapOrchestrator.ControlType.ZOOM);'.PHP_EOL;
        $result .= '    orc.switchMapControl('.$controlOpts['scalecontrol'].', jQuery.GoogleMapOrchestrator.ControlType.SCALE);'.PHP_EOL;
        $result .= '    orc.switchMapControl('.$controlOpts['streetviewcontrol'].', jQuery.GoogleMapOrchestrator.ControlType.STREETVIEW);'.PHP_EOL;

		return $result;
	}
endif;


if ( !function_exists('cgmp_draw_map_marker_v2') ):
	function cgmp_draw_map_marker_v2($id, $extramarkers, $kml) {

		$result = "";

		if ((!isset($kml) || $kml == "")) {

			if (isset($extramarkers) && $extramarkers != '') {
				$result .= '    orc.buildAddressMarkers("'.$extramarkers.'");'.PHP_EOL;
			}
		}

		return $result;
	}
endif;


if ( !function_exists('cgmp_draw_map_bikepath') ):
	function cgmp_draw_map_bikepath($id, $showbikepath) {
		$result = '';
		if (isset($showbikepath) && strtolower(trim($showbikepath)) == 'true') {
			$result = 'orc.buildLayer(jQuery.GoogleMapOrchestrator.LayerType.BIKE);'.PHP_EOL;
		}
		return $result;
	}
endif;

if ( !function_exists('cgmp_draw_map_traffic') ):
	function cgmp_draw_map_traffic($id, $showtraffic) {
		$result = '';
		if (isset($showtraffic) && strtolower(trim($showtraffic)) == 'true') {
			$result = 'orc.buildLayer(jQuery.GoogleMapOrchestrator.LayerType.TRAFFIC);'.PHP_EOL;
		}
		return $result;
	}
endif;


if ( !function_exists('cgmp_draw_kml') ):
	function cgmp_draw_kml($id, $kml) {
		$result = '';
		if (isset($kml) && $kml != "" && strtolower(trim(strpos($kml, "http"))) !== false) {
			$kml = str_replace("&#038;", "&", $kml);
			$result = 'orc.buildLayer(jQuery.GoogleMapOrchestrator.LayerType.KML, "'.$kml.'");'.PHP_EOL;
		}
		return $result;
	}
endif;


if ( !function_exists('cgmp_draw_panoramio') ):
	function cgmp_draw_panoramio($id, $showpanoramio, $userId) {
		$result = '';
		if (isset($showpanoramio) && strtolower(trim($showpanoramio)) == 'true') {
			$result = 'orc.buildLayer(jQuery.GoogleMapOrchestrator.LayerType.PANORAMIO, null, "'.$userId.'");'.PHP_EOL;
		}
		return $result;
	}
endif;



if ( !function_exists('cgmp_end_map_init') ):
	function cgmp_end_map_init() {
		$result =  '});</script>';
		return 	$result;
	}
endif;


if ( !function_exists('cgmp_create_html_select') ):
	function cgmp_create_html_select($attr) {
		$role = $attr['role'];
		$id = $attr['id'];
		$name = $attr['name'];
		$value = $attr['value'];
		$options = $attr['options'];
				
		return "<select role='".$role."' id='".$id."' style='' class='shortcodeitem' name='".$name."'>".
				cgmp_create_html_select_options($options, $value)."</select>";
	}
endif;


if ( !function_exists('cgmp_create_html_select_options') ):
	function cgmp_create_html_select_options( $options, $so ){
		$r = '';
		foreach ($options as $label => $value){
			$r .= '<option value="'.$value.'"';
			if($value == $so){
				$r .= ' selected="selected"';
			}
			$r .= '>&nbsp;'.$label.'&nbsp;</option>';
		}
		return $r;
	}
endif;


if ( !function_exists('cgmp_create_html_input') ):
	function cgmp_create_html_input($attr) {
		$role = $attr['role'];
		$id = $attr['id'];
		$name = $attr['name'];
		$value = $attr['value'];
		$class = $attr['class'];
		$style = $attr['style'];
		$elem_type = 'text';

		if (isset($attr['elem_type'])) {
			$elem_type = $attr['elem_type'];
		}
		$steps = "";
		$slider = "";
		if ($elem_type == "range") {
				$slider = "<div id='".$role."' class='slider'></div>";
				$class .= " slider-output";
		}
		return $slider."<input role='".$role."' {$steps} class='".$class." shortcodeitem' id='".$id."' name='".$name."' value='".$value."' style='".$style."' />";
	}
endif;

if ( !function_exists('cgmp_create_html_hidden') ):
		function cgmp_create_html_hidden($attr) {
				$id = $attr['id'];
				$name = $attr['name'];
				$value = $attr['value'];
				$class = $attr['class'];
				$style = $attr['style'];
			return "<input class='".$class."' id='".$id."' name='".$name."' value='".$value."' style='".$style."' type='hidden' />";
	}
endif;


if ( !function_exists('cgmp_create_html_button') ):
		function cgmp_create_html_button($attr) {
				$id = $attr['id'];
				$name = $attr['name'];
				$value = $attr['value'];
				$class = $attr['class'];
				$style = $attr['style'];
			return "<input class='".$class."' id='".$id."' name='".$name."' value='".$value."' style='".$style."' type='button' />";
	}
endif;

if ( !function_exists('cgmp_create_html_list') ):
		function cgmp_create_html_list($attr) {
				$id = $attr['id'];
				$name = $attr['name'];
				$class = $attr['class'];
				$style = $attr['style'];
			return "<ul class='".$class."' id='".$id."' name='".$name."' style='".$style."'></ul>";
	}
endif;



if ( !function_exists('cgmp_create_html_label') ):
		function cgmp_create_html_label($attr) {
			$for = $attr['for'];
			$value = $attr['value'];
		 	return "<label for=".$for.">".$value."</label>";
	}
endif;


if ( !function_exists('cgmp_create_html_custom') ):
		function cgmp_create_html_custom($attr) {
				$id = $attr['id'];
				$name = $attr['name'];
				$class = $attr['class'];
				$style = $attr['style'];
				$start =  "<ul class='".$class."' id='".$id."' name='".$name."' style='".$style."'>";

				$markerDir = CGMP_PLUGIN_IMAGES_DIR . "/markers/";

				$items = "<div id='".$id."' class='".$class."' style='margin-bottom: 15px; padding-bottom: 10px; padding-top: 10px; padding-left: 30px; height: 200px; overflow: auto; border-radius: 4px 4px 4px 4px; border: 1px solid #C9C9C9;'>";
				if (is_readable($markerDir)) {

					if ($dir = opendir($markerDir)) {

						$files = array();
						while ($files[] = readdir($dir));
						sort($files);
						closedir($dir);

						foreach ($files as $file) {
							//echo "filename: $file : filetype: " . filetype($dir . $file) . "\n";
							$pos = strrpos($file, ".png");

							if ($pos !== false && $file != "shadow.png") {
									$class = "";
									$style = "";
									$sel = "";
									$iconId = "";
									$radioId = "";
									$src = CGMP_PLUGIN_IMAGES."/markers/".$file;
									if ($file == "1-default.png") {
											$class = "selected-marker-image nomarker";
											$style = "cursor: default; ";
											$sel = "checked='checked'";
											$iconId = "default-marker-icon";
											$radioId = $iconId."-radio";
									} else if ($file == "2-default.png" || $file == "3-default.png") {
											$class = "nomarker";
									}

									//$items .= "<li><a href='javascript:void(0);'><img id='".$iconId."' style='".$style."' class='".$class."' src='".$src."' border='0' /></a><br /><input ".$sel." type='radio' id='".$radioId."' value='".$src."' style='margin-right: 15px' name='custom-icons-radio' /></li>";
									$items .= "<div style='float: left; text-align: center; margin-right: 8px;'><a href='javascript:void(0);'><img id='".$iconId."' style='".$style."' class='".$class."' src='".$src."' border='0' /></a><br /><input ".$sel." type='radio' id='".$radioId."' value='".$file."' style='' name='custom-icons-radio' /></div>";

							}
        				}
					}
				}


			return $items."</div>";
			//return $start.$items."</ul>";
	}
endif;


if ( !function_exists('cgmp_replace_template_tokens') ):
	function cgmp_replace_template_tokens($token_values, $template)  {
		foreach ($token_values as $key => $value) {
			$template = str_replace($key, $value, $template);
		}
		return $template;
	}
endif;


if ( !function_exists('cgmp_build_template_values') ):
	function cgmp_build_template_values($settings) {
		$template_values = array();

		foreach($settings as $setting) {
			$func_type = $setting['type'];
			$token = $setting['token'];
			$attr = $setting['attr'];

			$pos = strrpos($func_type, "@");

			if ($pos != 0) {
				$pieces = explode("@", $func_type);
				$func_type = $pieces[0];
				$attr['elem_type'] = $pieces[1];
			}


			$func =  "cgmp_create_html_".$func_type;
			$template_values[strtoupper($func_type)."_".strtoupper($token)] = $func($attr);
		}
		return $template_values;
	}
endif;

?>
