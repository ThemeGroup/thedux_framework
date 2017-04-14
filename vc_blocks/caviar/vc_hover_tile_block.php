<?php 

/**
 * The Shortcode
 */
function thedux_hover_tile_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'animation' => 'zoom--in',
				'image' => '',
				'type' => 'top__left',
				'text_align' => 'text-left', 
				'background' => '', // bg--primary
				'height' => '50',
				'opacity' => '0',
				'hover' => '',
				'title' => '',
				'subtitle' => '',
				'button_animation' => '',
				'button_text' => '',
				'link' => '#',
				'button_type' => 'btn--primary',
				'button_size' => '',
				'custom_css' => '',
			), $atts 
		) 
	);
	
	$v_pos = $h_pos = "";
	
	switch( $type ):
		case 'top__left':
			$v_pos = 'top';
			$h_pos = 'left';
			break;
		case 'top__center':
			$v_pos = 'top';
			$h_pos = 'center';
			break;
		case 'top__right':
			$v_pos = 'top';
			$h_pos = 'right';
			break;
		case 'center__left':
			$v_pos = 'center';
			$h_pos = 'left';
			break;
		case 'center__center':
			$v_pos = 'center';
			$h_pos = 'center';
			break;
		case 'center__right':
			$v_pos = 'center';
			$h_pos = 'right';
			break;
		case 'bottom__left':
			$v_pos = 'bottom';
			$h_pos = 'left';
			break;
		case 'bottom__center':
			$v_pos = 'bottom';
			$h_pos = 'center';
			break;
		case 'bottom__right':
			$v_pos = 'bottom';
			$h_pos = 'right';
			break;
		default:
			$v_pos = 'top';
			$h_pos = 'left';
			break;
	endswitch;
	
	$output = '
		<div class="hover-element hover-element-1 v__height-'.$height.' '.$animation.' '.$background.' '.$custom_css.'">
			<div class="hover-element__thumb">
				<div class="image-bg-wrap">
				'. wp_get_attachment_image( $image, 'large' ) .'
				</div>
			</div>
			<div class="hover-element__overlay" data-hover-opacity="'.$opacity.'"></div>
			<div class="hover-element__description" data-hover-preset="'.$hover.'">
				<div class="collection-thumb__title '.$text_align.'" data-v-pos="'.$v_pos.'" data-h-pos="'.$h_pos.'">
					'. ( ($title != '') ? '<h4>'. htmlspecialchars_decode($title) .'</h4>' : '' ) .'
					'. ( ($subtitle != '') ? '<p>'. htmlspecialchars_decode($subtitle) .'</p>' : '' ) .'
					'. ( ($button_text != '') ? '<p>'.do_shortcode('[caviar_button button_text="'.$button_text.'" link="'.$link.'" type="'.$button_type.'" size="'.$button_size.'" animation="'.$button_animation.'"]').'</p>' : '' ) .'
				</div>
			</div>
		</div><!--end hover element-->
	';
	
	return $output;
}
add_shortcode( 'caviar_hover_tile', 'thedux_hover_tile_shortcode' );

/**
 * The VC Functions
 */
function thedux_hover_tile_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'caviar-vc-block',
			"name" => esc_html__("Hover Tiles", 'caviar'),
			"base" => "caviar_hover_tile",
			"category" => esc_html__('Caviar Theme', 'caviar'),
			"params" => array(
				array(
					"type" => "attach_image",
					"heading" => esc_html__("Block Image", 'caviar'),
					"param_name" => "image"
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Display Type", 'caviar'),
					"param_name" => "type",
					"value" => array(
						'Top Left' => 'top__left',
						'Top Center' => 'top__center',
						'Top Right' => 'top__right',
						'Center Left' => 'center__left',
						'Center Center' => 'center__center',
						'Center Right' => 'center__right',
						'Bottom Left' => 'bottom__left',
						'Bottom Center' => 'bottom__center',
						'Bottom Right' => 'bottom__right',
					)
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Text Align", 'caviar'),
					"param_name" => "text_align",
					"value" => array(
						'Left' => 'text-left',
						'Center' => 'text-center',
						'Right' => 'text-right',
					)
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Background Style", 'caviar'),
					"param_name" => "background",
					"value" => array(
						'Normal' => '',
						'Primary' => 'bg--primary',
					)
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Block Height", 'caviar'),
					"param_name" => "height",
					"value" => array(
						'10vh' => '10',
						'20vh' => '20',
						'30vh' => '30',
						'40vh' => '40',
						'50vh' => '50',
						'60vh' => '60',
						'70vh' => '70',
						'80vh' => '80',
						'90vh' => '90',
						'100vh' => '100'
					),
					"std" => '50'
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Overlay Opacity", 'caviar'),
					"param_name" => "opacity",
					"value" => array(
						'0%' => '0',
						'10%' => '1',
						'20%' => '2',
						'30%' => '3',
						'40%' => '4',
						'50%' => '5',
						'60%' => '6',
						'70%' => '7',
						'80%' => '8',
						'90%' => '9',
						'100%' => '10',
					)
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Hover Preset", 'caviar'),
					"param_name" => "hover",
					"value" => array(
						'Dark' => 'dark',
						'Light' => 'light',
					)
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Title", 'caviar'),
					"param_name" => "title",
					'holder' => 'div'
				),
				array(
					"type" => "textarea",
					"heading" => esc_html__("Subtitle", 'caviar'),
					"param_name" => "subtitle",
					"value" => ""
				),
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
					"type" => "dropdown",
					"heading" => esc_html__("Button Style", 'caviar'),
					"param_name" => "button_type",
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
						"Border" => 'btn--border',
					)
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Button Size", 'caviar'),
					"param_name" => "button_size",
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
					"param_name" => "button_animation",
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
add_action( 'vc_before_init', 'thedux_hover_tile_shortcode_vc' );