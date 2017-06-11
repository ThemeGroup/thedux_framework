<?php

/**
 * The Shortcode
 */
function thedux_styled_map_shortcode( $atts, $content = null ) {

	$map_style = '[{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}]';

	extract(
		shortcode_atts(
			array(
				'api_key' => '',
				'address' => '',
				'style' => $map_style,
				'custom_css_class' => ''
			), $atts
		)
	);

	$final_style = ( $style == $map_style ) ? $style : htmlspecialchars_decode(rawurldecode(base64_decode($style)));
	if( '' == $final_style ){
		$final_style = $map_style;
	}

	$output = '<div class="map-container '. esc_attr($custom_css_class) .'" data-maps-api-key="'. $api_key .'" data-address="'. $address .'" data-marker-title="'. esc_attr(get_bloginfo('title')) .'" data-map-style="'. esc_attr($final_style) .'"></div>';


	return $output;
}
add_shortcode( 'lugos_styled_map', 'thedux_styled_map_shortcode' );

/**
 * The VC Functions
 */
function thedux_styled_map_shortcode_vc() {
	vc_map(
		array(
			"icon" => 'lugos-vc-block',
			"name" => esc_html__("Styled Google Map", 'lugos'),
			"base" => "lugos_styled_map",
			"category" => esc_html__('Lugos Theme', 'lugos'),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__("Google Maps API Key", 'lugos'),
					"param_name" => "api_key",
					"description" => "Follow Google's instructions <a href='https://developers.google.com/maps/documentation/javascript/get-api-key' target='_blank'>here</a> on how to obtain an API key. When you have your key, proceed to the next section to learn how to set up your pages with the API key and the map.",
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Street Address", 'lugos'),
					"param_name" => "address",
					"description" => "Enter your desired map location street address.",
				),
				array(
					"type" => "textarea_raw_html",
					"heading" => esc_html__("Map Custom Style", 'lugos'),
					"param_name" => "style",
					"description" => 'Apply any style from <a href="http://snazzymaps.com">Snazzy Maps</a> or <a href="https://mapstyle.withgoogle.com/">make your own</a>',
					'value' => '[{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}]'
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Extra CSS Class Name", 'lugos'),
					"param_name" => "custom_css_class",
					"description" => '<code>DEVELOPERS ONLY</code> - Style particular content element differently - add a class name and refer to it in custom CSS.',
				),
			)
		)
	);
}
add_action( 'vc_before_init', 'thedux_styled_map_shortcode_vc' );