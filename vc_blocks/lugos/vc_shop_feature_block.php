<?php

/**
 * The Shortcode
 */
function thedux_shop_feature_shortcode ( $atts ) {
	extract(
		shortcode_atts(
			array(
				'active' => '',
				'icon' => '',
				'title' => '',
				'subtitle' => '',
			), $atts
		)
	);
	
	$active_class = ( $active == 'yes' ) ? 'active' : '';
	
	$output = '
		<div class="shortcode__shop-feature clearfix '. $active_class .'">
			<div class="shop-feature-icon">
				<i class="icon--lugos '. esc_attr($icon) .'"></i>
			</div>
			<div class="shop-feature-desc">
				<h4>'. htmlspecialchars_decode($title) .'</h4>
				<p>'. htmlspecialchars_decode($subtitle) .'</p>
			</div>
		</div>
	';
	
	return $output;
}
add_shortcode( 'lugos_shop_feature', 'thedux_shop_feature_shortcode' );

/**
 * The VC Functions
 */
function thedux_shop_feature_shortcode_vc() {
	
	$icons = array('Install Themedeux Framework' => 'Install Themedeux Framework');
	
	if( function_exists('thedux_get_icons') ){
		$icons = thedux_get_icons();	
	}
	
	vc_map( 
		array(
			"icon" => 'lugos-vc-block',
			"name" => esc_html__("Shop Feature", 'lugos'),
			"base" => "lugos_shop_feature",
			"category" => esc_html__('Lugos Theme', 'lugos'),
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Block Active", 'lugos'),
					"param_name" => "active",
					"value" => array(
						'No' => 'no',
						'Yes' => 'yes'
					)
				),
				array(
					"type" => "thedux_icons",
					"heading" => esc_html__("Click an Icon to choose", 'lugos'),
					"param_name" => "icon",
					"value" => $icons,
					'description' => 'Type "none" or leave blank to hide icons.'
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Title", 'lugos'),
					"param_name" => "title",
					'holder' => 'div',
				),
				array(
					"type" => "textarea",
					"heading" => esc_html__("Block Content", 'lugos'),
					"param_name" => "subtitle",
				)
			)
		) 
	);
	
}
add_action( 'vc_before_init', 'thedux_shop_feature_shortcode_vc' );