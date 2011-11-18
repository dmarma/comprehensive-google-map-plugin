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

if ( !function_exists('cgmp_google_map_plugin_menu') ):
      function cgmp_google_map_plugin_menu() {
            add_menu_page("Comprehensive Google Map", 'Google Map', 'activate_plugins', basename(__FILE__), 'cgmp_parse_menu_html', CGMP_PLUGIN_IMAGES .'/google_map.png');
      }
endif;

if ( !function_exists('cgmp_parse_menu_html') ):
function cgmp_parse_menu_html() {
      if (!current_user_can('activate_plugins'))  {
                wp_die( __('You do not have sufficient permissions to access this page.') );
        }

	$template = file_get_contents(CGMP_PLUGIN_HTML."/documentation.plug");
        $template_content = file_get_contents(CGMP_PLUGIN_HTML."/form_body_template.plug");

        $template_values = array();
        $template_values["LABEL_WIDTH"] = "<b>Width</b>:";
        $template_values["INPUT_WIDTH"] = "The width of the map placeholder DIV in pixels";
        $template_values["LABEL_HEIGHT"] = "<b>Height</b>:";
        $template_values["INPUT_HEIGHT"] = "The height of the map placeholder DIV in pixels";
        $template_values["LABEL_LATITUDE"] = "<b>Latitude</b>:";
        $template_values["INPUT_LATITUDE"] = "Together with Longitude, makes a geographic coordinate of a location displayed on the Google map. The latitude coordinate value is measured in degrees";
        $template_values["LABEL_LONGITUDE"] = "<b>Longitude</b>:";
        $template_values["INPUT_LONGITUDE"] =  "Together with Latitude, makes a geographic coordinate of a location displayed on the Google map. The longitude coordinate value is measured in degrees";
        $template_values["LABEL_ZOOM"] = "<b>Zoom</b>:";
        $template_values["INPUT_ZOOM"] = "Each map also contains a zoom level, which defines the resolution of the current view. Zoom levels between 0 (the lowest zoom level, in which the entire world can be seen on one map) to 19 (the highest zoom level, down to individual buildings) are possible within the normal maps view. Zoom levels vary depending on where in the world you're looking, as data in some parts of the globe is more defined than in others. Zoom levels up to 20 are possible within satellite view.";
        $template_values["LABEL_MAPTYPE"] = "<b>Map&nbsp;type</b>:";
        $template_values["SELECT_MAPTYPE"] = "There are many types of maps available within the Google Maps. In addition to the familiar 'painted' road map tiles, the Google Maps API also supports other maps types. The following map types are available in the Google Maps API:
ROADMAP displays the default road map view, SATELLITE displays Google Earth satellite images, HYBRID displays a mixture of normal and satellite views, TERRAIN displays a physical map based on terrain information.";
        
        $template_values["LABEL_SHOWMARKER"] = "<b>Primary&nbsp;Marker</b>";
        $template_values["SELECT_SHOWMARKER"] = "If a map is specified, the marker is added to the map upon construction. Note that the position must be set for the marker to display."; 
        $template_values["LABEL_ANIMATION"] = "<b>Animation</b>";
        $template_values["SELECT_ANIMATION"]    = "Animations can be played on a primary marker. Currently two types of animations supported: BOUNCE makes marker to bounce until animation is stopped, DROP makes primary marker to fall from the top of the map ending with a small bounce.";
        $template_values["LABEL_M_APTYPECONTROL"] = "<b>MapType</b>";
        $template_values["SELECT_M_APTYPECONTROL"] = "The MapType control lets the user toggle between map types (such as ROADMAP and SATELLITE). This control appears by default in the top right corner of the map";
	$template_values["LABEL_PANCONTROL"] = "<b>Pan</b>";
        $template_values["SELECT_PANCONTROL"] = "The Pan control displays buttons for panning the map. This control appears by default in the top left corner of the map on non-touch devices. The Pan control also allows you to rotate 45� imagery, if available.";
        $template_values["LABEL_Z_OOMCONTROL"] = "<b>Zoom</b>";
        $template_values["SELECT_Z_OOMCONTROL"] = "The Zoom control displays a slider (for large maps) or small '+/-' buttons (for small maps) to control the zoom level of the map. This control appears by default in the top left corner of the map on non-touch devices or in the bottom left corner on touch devices.";
        $template_values["LABEL_SCALECONTROL"] = "<b>Scale</b>"; 
        $template_values["SELECT_SCALECONTROL"] = "The Scale control displays a map scale element. This control is not enabled by default.";
        $template_values["LABEL_STREETVIEWCONTROL"] = "<b>StreetView</b>";
        $template_values["SELECT_STREETVIEWCONTROL"] = "The Street View control contains a Pegman icon which can be dragged onto the map to enable Street View. This control appears by default in the top left corner of the map";

        $template_values["LABEL_INFOBUBBLECONTENT"] = "<b>Content&nbsp;Text</b>"; 
        $template_values["INPUT_INFOBUBBLECONTENT"] = "Text to be displayed inside info bubble (info window).";

        $template_values["LABEL_ADDRESSCONTENT"] = "<b>Address&nbsp;Text</b>"; 
        $template_values["INPUT_ADDRESSCONTENT"] = "Geographical gestination address string. The address supersedes longitude and latitude configuration. If the address provided cannot be parsed (eg: invalid address) by Google, the map will display error message in the info bubble over default location (New York, USA). Please note, address configuration *supersedes* latitude/longitude settings";

        $template_values["LABEL_SHOWBIKE"] = "<b>Bike&nbsp;Paths</b>";
        $template_values["SELECT_SHOWBIKE"] = "A layer showing bike lanes and paths as overlays on a Google Map.";
        $template_values["LABEL_SHOWTRAFFIC"] = "<b>Traffic&nbsp;Info</b>";
        $template_values["SELECT_SHOWTRAFFIC"] = "A layer showing vehicle traffic as overlay on a Google Map.";
        $template_values["LABEL_KML"] = "<b>KML/GeoRSS&nbsp;URL</b>";
		$template_values["INPUT_KML"] = "KML is a file format used to display geographic data in an earth browser, such as Google Earth, Google Maps, and Google Maps for mobile. A KML file is processed in much the same way that HTML (and XML) files are processed by web browsers. Like HTML, KML has a tag-based structure with names and attributes used for specific display purposes. Thus, Google Earth and Maps act as browsers for KML files. Please note, KML configuration *supersedes* address and latitude/longitude settings";
		$template_values["LABEL_ADDMARKERINPUT"] = "<b>Extra&nbsp;Markers</b>";
		$template_values["INPUT_ADDMARKERINPUT"] = "Apart from specifying primary marker for the map, you can specify additional markers. You can eneter either latitude and longitude, comma seperated or a full geographical address. The generated marker will have an info bubble attached to it, with marker's address as a bubble content. If latitude/longitude was provided as a marker location, the bubble content will contain location geographical address instead of the latitude/longitude. Please note that additional markers do not support animation at the moment.";
		$template_values["BUTTON_ADDMARKER"] = "";
		$template_values["LIST_ADDMARKERLIST"] = "";
		$template_values["HIDDEN_ADDMARKERLISTHIDDEN"] = "";
		$template_values["LABEL_SHOWPANORAMIO"] = "<b>Panoramio</b>";
		$template_values["SELECT_SHOWPANORAMIO"] = "Panoramio (http://www.panoramio.com) is a geolocation-oriented photo sharing website. Accepted photos uploaded to the site can be accessed as a layer in Google Earth and Google Maps, with new photos being added at the end of every month. The site's goal is to allow Google Earth users to learn more about a given area by viewing the photos that other users have taken at that place.";


		$template_values["LABEL_BUBBLEAUTOPAN"] = "<b>Bubble&nbsp;Auto-Pan</b>";
		$template_values["SELECT_BUBBLEAUTOPAN"] = "Enables bubble auto-pan on marker click. By default, the info bubble will pan the map so that it is fully visible when it opens.";


		$template_values["FOOTER_NOTICES"] = "";

	global $global_fieldset_names;
        $template_content = cgmp_replace_template_tokens($global_fieldset_names, $template_content);
        $template_content = cgmp_replace_template_tokens($template_values, $template_content);

        $template_values = array();
        $template_values["DOCUMENTATION_TOKEN"] = $template_content;

        $template = cgmp_replace_template_tokens($template_values, $template);
        echo $template;

}	
endif;

?>