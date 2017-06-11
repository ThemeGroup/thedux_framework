<?php 

/**
 * The Shortcode
 */
function thedux_masonry_grid_shortcode( $atts, $content = null ){
	extract(
		shortcode_atts(
			array(
				'gap' => '',
				'columns' => '3',
				'custom_css' => '',
			), $atts
		)
	);
	
	global $masonry_grid_columns, $masonry_wrapped;
	$masonry_grid_columns = '';
	$masonry_wrapped = 1;
	
	switch( $columns ):
		case 1:
			$masonry_grid_columns = 'col-sm-12';
			break;
		case 2:
			$masonry_grid_columns = 'col-sm-6';
			break;
		case 3:
			$masonry_grid_columns = 'col-sm-4';
			break;
		case 4:
			$masonry_grid_columns = 'col-sm-3';
			break;
		case 6:
			$masonry_grid_columns = 'col-sm-2';
			break;
		default:
			$masonry_grid_columns = 'col-sm-4';
			break;
	endswitch;
	
	$output = '
	<div class="masonry '.(($gap=='none')?'masonry--nogap':'').' '.$custom_css.'">
		<div class="row">
			<div class="masonry__container">
			<div class="col-md-1 masonry__item"></div>
			'.do_shortcode($content).'
			</div>
		</div>
	</div>
	';
	
	$masonry_grid_columns = null;
	$masonry_wrapped = null;
	
	return $output;
}
add_shortcode( 'lugos_masonry_grid', 'thedux_masonry_grid_shortcode' );

/**
 * The Shortcode
 */
function thedux_hover_tile_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'animation' => 'zoom--in',
				'image' => '',
				'type' => 'centered',
				'text_align' => 'text-left', 
				'background' => '', // bg--primary
				'width' => '',
				'height' => '50',
				'opacity' => '0',
				'hover' => '',
				'hidden' => '',
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
			$v_pos = '';
			$h_pos = '';
			break;
	endswitch;
	
	global $masonry_grid_columns, $masonry_wrapped;
	$column_css = $masonry_grid_columns;
	if($width != '') $column_css = $width;
	
	$output = '';
	
	if(isset($masonry_wrapped) && $masonry_wrapped==1){
		$output .= '<div class="'.$column_css.' col-xs-12 masonry__item">';
	}
	
	$output .= '
		<div class="hover-element__box hover-element hover-element-1 v__height-'.$height.' '.$animation.' '.$background.' '.$custom_css.'">
			<div class="hover-element__thumb">
				<div class="image-bg-wrap">
				'. wp_get_attachment_image( $image, 'large' ) .'
				</div>
			</div>
			<div class="hover-element__overlay" data-hover-opacity="'.$opacity.'"></div>
			<div class="hover-element__description '.( ($hidden == 'hidden')?'hidden--default':'' ).'" data-hover-preset="'.$hover.'">
				<div class="collection-thumb__title '.$text_align.'" data-v-pos="'.$v_pos.'" data-h-pos="'.$h_pos.'">
					'. ( ($title != '') ? '<h4>'. htmlspecialchars_decode($title) .'</h4>' : '' ) .'
					'. ( ($subtitle != '') ? '<p>'. htmlspecialchars_decode($subtitle) .'</p>' : '' ) .'
					'. ( ($button_text != '') ? '<p>'.do_shortcode('[lugos_button button_text="'.$button_text.'" link="'.$link.'" type="'.$button_type.'" size="'.$button_size.'" animation="'.$button_animation.'"]').'</p>' : '' ) .'
				</div>
			</div>
		</div><!--end hover element-->
	';
	
	if(isset($masonry_wrapped) && $masonry_wrapped==1){
		$output .= '</div>';
	}
	
	return $output;
}
add_shortcode( 'lugos_hover_tile', 'thedux_hover_tile_shortcode' );

/**
 * The VC Functions
 */
function thedux_masonry_grid_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'lugos-vc-block',
		    'name'                    => esc_html__( 'Masonry Grid' , 'lugos' ),
		    'base'                    => 'lugos_masonry_grid',
		    'as_parent'               => array('only' => 'lugos_hover_tile'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
		    'content_element'         => true,
		    'show_settings_on_create' => true,
		    "js_view" => 'VcColumnView',
		    "category" => esc_html__('Lugos Theme', 'lugos'),
		    'params'          => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Column", 'lugos'),
					"param_name" => "columns",
					"value" => array(
						'3' => '3',
						'1' => '1',
						'2' => '2',
						'4' => '4',
						'6' => '6',
					)
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
				array(
					"type" => "textfield",
					"heading" => esc_html__("Extra class name", 'lugos'),
					"param_name" => "custom_css"
				),
		    )
		) 
	);
}
add_action( 'vc_before_init', 'thedux_masonry_grid_shortcode_vc' );

/**
 * The VC Functions
 */
function thedux_hover_tile_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'lugos-vc-block',
			"name" => esc_html__("Hover Tiles", 'lugos'),
			"base" => "lugos_hover_tile",
			"category" => esc_html__('Lugos Theme', 'lugos'),
			"params" => array(
				array(
					"type" => "attach_image",
					"heading" => esc_html__("Block Image", 'lugos'),
					"param_name" => "image"
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Display Type", 'lugos'),
					"param_name" => "type",
					"value" => array(
						'Centered' => 'centered',
						'Top Left' => 'top__left',
						'Top Center' => 'top__center',
						'Top Right' => 'top__right',
						'Center Left' => 'center__left',
						//'Center Center' => 'center__center',
						'Center Right' => 'center__right',
						'Bottom Left' => 'bottom__left',
						'Bottom Center' => 'bottom__center',
						'Bottom Right' => 'bottom__right',
					)
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Text Align", 'lugos'),
					"param_name" => "text_align",
					"value" => array(
						'Left' => 'text-left',
						'Center' => 'text-center',
						'Right' => 'text-right',
					)
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Background Style", 'lugos'),
					"param_name" => "background",
					"value" => array(
						'Normal' => '',
						'Primary' => 'bg--primary',
					)
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Block Width", 'lugos'),
					"param_name" => "width",
					"value" => array(
						'Inherit' => '',
						'1/6 grid' => 'col-sm-2',
						'1/4 grid' => 'col-sm-3',
						'1/3 grid' => 'col-sm-4',
						'5/12 grid' => 'col-sm-5',
						'1/2 grid' => 'col-sm-6',
						'7/12 grid' => 'col-sm-7',
						'2/3 grid' => 'col-sm-8',
						'3/4 grid' => 'col-sm-9',
						'full grid' => 'col-sm-12',
					),
					"std" => '50'
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Block Height", 'lugos'),
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
					"heading" => esc_html__("Overlay Opacity", 'lugos'),
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
					"heading" => esc_html__("Hover Preset", 'lugos'),
					"param_name" => "hover",
					"value" => array(
						'Dark' => 'dark',
						'Light' => 'light',
					)
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Hidden Content", 'lugos'),
					"param_name" => "hidden",
					"value" => array(
						'None' => '',
						'Hidden' => 'hidden',
					)
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Title", 'lugos'),
					"param_name" => "title",
					'holder' => 'div'
				),
				array(
					"type" => "textarea",
					"heading" => esc_html__("Subtitle", 'lugos'),
					"param_name" => "subtitle",
					"value" => ""
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Button Text", 'lugos'),
					"param_name" => "button_text",
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("URL for button", 'lugos'),
					"param_name" => "link"
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Button Style", 'lugos'),
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
						"Underline Dark" => 'btn--underline--dark',
						"Underline Light" => 'btn--underline--light',
						"Border" => 'btn--border',
						"Border Dark" => 'btn--border--dark',
						"Border Light" => 'btn--border--light',
					)
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Button Size", 'lugos'),
					"param_name" => "button_size",
					"value" => array(
						"Normal" => '',
						"Mini" => 'btn--xs',
						"Small" => 'btn--sm',
						"Large" => 'btn--lg',
					),
					"std" => '',
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Button Animation", 'lugos'),
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
					"heading" => esc_html__("Extra class name", 'lugos'),
					"param_name" => "custom_css"
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'thedux_hover_tile_shortcode_vc' );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_lugos_masonry_grid extends WPBakeryShortCodesContainer {

    }
}