<?php 

/**
 * The Shortcode
 */
function thedux_button_shortcode( $atts ) {
	extract( 
		shortcode_atts( 
			array(
				'animation' => '',
				'icon' => '',
				'button_text' => '',
				'link' => '#',
				'type' => 'btn--primary',
				'size' => '',
				'custom_css' => '',
			), $atts 
		) 
	);
	
	$output = '
		<a class="btn '.$type.' '.$size.' '.$animation.' '.$custom_css.'" href="'.$link.'">
			<span class="btn__text">'. ( ($icon != '' && $icon != 'none') ? '<i class="'.$icon.'"></i>' : '' ) .' '.$button_text.' </span>
		</a>
	';
	
	return $output;
}
add_shortcode( 'caviar_button', 'thedux_button_shortcode' );

/**
 * The VC Functions
 */
function thedux_button_shortcode_vc() {
	
	$icons = array('Install Themedeux Framework' => 'Install Themedeux Framework');
	
	if( function_exists('thedux_get_icons') ){
		$icons = thedux_get_icons();	
	}
	
	vc_map(
		array(
			"icon" => 'caviar-vc-block',
			"name" => esc_html__("Caviar Button", 'caviar'),
			"base" => "caviar_button",
			"category" => esc_html__('Caviar Theme', 'caviar'),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__("Button Text", 'caviar'),
					"param_name" => "button_text",
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("URL for button", 'caviar'),
					"param_name" => "link"
				),
				array(
					"type" => "thedux_icons",
					"heading" => esc_html__("Click an Icon to choose", 'caviar'),
					"param_name" => "icon",
					"value" => $icons,
					'description' => 'Type "none" or leave blank to hide icons.'
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Button Style", 'caviar'),
					"param_name" => "type",
					"value" => array(
						"Primary" => 'btn--primary',
						"Secondary" => 'btn--secondary',
						"White" => 'btn--white',
						"Dark" => 'btn--dark',
						"Transparent" => 'btn--transparent',
						"Unfilled" => 'btn--unfilled',
						"Shadow" => 'btn--shadow',
						"Shadow White" => 'btn--shadow btn--white',
						"Underline" => 'btn--underline',
						"Underline Dark" => 'btn--underline--dark',
						"Border" => 'btn--border',
						"Border Dark" => 'btn--border--dark',
					)
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Button Size", 'caviar'),
					"param_name" => "size",
					"value" => array(
						"Mini" => 'btn--xs',
						"Small" => 'btn--sm',
						"Normal" => '',
						"Large" => 'btn--lg',
					),
					"std" => '',
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Button Animation", 'caviar'),
					"param_name" => "animation",
					"value" => array(
						"None" => '',
						"Sweep To Right" => 'hvr-sweep-to-right',
						"Sweep To Left" => 'hvr-sweep-to-left',
						"Sweep To Bottom" => 'hvr-sweep-to-bottom',
						"Sweep To Top" => 'hvr-sweep-to-top',
						"Bounce To Right" => 'hvr-bounce-to-right',
						"Bounce To Left" => 'hvr-bounce-to-left',
						"Bounce To Bottom" => 'hvr-bounce-to-bottom',
						"Bounce To Top" => 'hvr-bounce-to-top',
						"Radial Out" => 'hvr-radial-out',
						"Radial In" => 'hvr-radial-in',
						"Rectangle In" => 'hvr-rectangle-in',
						"Rectangle Out" => 'hvr-rectangle-out',
						"Shutter In Horizontal" => 'hvr-shutter-in-horizontal',
						"Shutter Out Horizontal" => 'hvr-shutter-out-horizontal',
						"Shutter In Vertical" => 'hvr-shutter-in-vertical',
						"Shutter Out Vertical" => 'hvr-shutter-out-vertical',
					)
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Extra class name", 'caviar'),
					"param_name" => "custom_css"
				),	
			)
		)
	);
}
add_action( 'vc_before_init', 'thedux_button_shortcode_vc');