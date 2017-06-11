<?php 

/**
 * The Shortcode
 */
function thedux_instafeed_shortcode( $atts ) {
	extract(
		shortcode_atts(
			array(
				'access_token' => '',
				'user_name' => '',
				'imgsize' => 'medium',
				'photos' => '20',
				'columns' => '4',
				'gap' => '',
			), $atts
		)
	);
	
	if($columns < 1){
		$columns = 1;
	}
	if($columns > 8){
		$columns = 8;
	}
	
	$output = '<div class="instafeed '.(($gap=='none')?'instafeed--nogap':'').'" data-access-token="'.esc_attr($access_token).'" data-user-name="'.esc_attr($user_name).'" data-res="'.esc_attr($imgsize).'" data-amount="'.esc_attr($photos).'" data-grid="'.esc_attr($columns).'"></div>';
	
	return $output;
}
add_shortcode( 'lugos_instafeed', 'thedux_instafeed_shortcode' );

/**
 * The VC Functions
 */
function thedux_instafeed_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'lugos-vc-block',
			"name" => esc_html__("Instagram Feed", 'lugos'),
			"base" => "lugos_instafeed",
			"category" => esc_html__('Lugos Theme', 'lugos'),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__("User Name", 'lugos'),
					"param_name" => "user_name",
					"value" => ""
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Image Resolution", 'lugos'),
					"param_name" => "imgsize",
					"value" => array(
						"Medium" => "medium",
						"Small" => "small",
						"Big" => "big"
					)
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Number of Photos", 'lugos'),
					"param_name" => "photos",
					"value" => "20"
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Number of Columns", 'lugos'),
					"param_name" => "columns",
					"value" => array(
						"4" => "4",
						"1" => "1",
						"2" => "2",
						"3" => "3",
						"5" => "5",
						"6" => "6",
						"7" => "7",
						"8" => "8",
					),
					"std" => '4'
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Gap", 'lugos'),
					"param_name" => "gap",
					"value" => array(
						'Default' => '',
						'No Gap' => 'none',
					)
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'thedux_instafeed_shortcode_vc' );