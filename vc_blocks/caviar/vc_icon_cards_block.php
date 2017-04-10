<?php 

/**
 * The Shortcode
 */
function thedux_icon_box_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'title' => '',
				'icon' => '',
				'layout' => 'standard',
				'alignment' => 'standard',
			), $atts 
		) 
	);
	
	if( 'standard' == $layout ){
		
		$output = '
			<div class="feature feature-1 '. esc_attr($alignment) .'">
				<i class="icon--caviar '. esc_attr($icon) .'"></i>
				<h5>'. htmlspecialchars_decode($title) .'</h5>
				'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
			</div>
		';
	
	} elseif( 'small' == $layout ){
		
		$output = '
			<div class="feature feature-1 '. esc_attr($alignment) .'">
				<i class="icon--caviar '. esc_attr($icon) .'"></i>
				<h6>'. htmlspecialchars_decode($title) .'</h6>
				'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
			</div>
		';
	
	} elseif( 'large' == $layout ){
		
		$output = '
			<div class="feature feature-1 '. esc_attr($alignment) .'">
				<i class="icon--caviar icon--lg '. esc_attr($icon) .'"></i>
				<h4>'. htmlspecialchars_decode($title) .'</h4>
				'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'</div>
		';
	
	} elseif( 'large-colored' == $layout ){
		
		$output = '
			<div class="feature feature-1 '. esc_attr($alignment) .'">
				<i class="icon--caviar color--primary icon--lg '. esc_attr($icon) .'"></i>
				<h4>'. htmlspecialchars_decode($title) .'</h4>
				'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'</div>
		';
	
	} elseif( 'boxed' == $layout ){
		
		$output = '
			<div class="feature boxed feature-1 '. esc_attr($alignment) .'">
				<i class="icon--caviar '. esc_attr($icon) .'"></i>
				<h5>'. htmlspecialchars_decode($title) .'</h5>
				'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
			</div>
		';
	
	} elseif( 'boxed-icon' == $layout ){
		
		$output = '
			<div class="card card-1">
				<div class="card__icon">
					<i class="icon--caviar icon--lg '. esc_attr($icon) .'"></i>
				</div>
				<div class="card__body boxed bg--white '. esc_attr($alignment) .'">
					<div class="card__title">
						<h5>'. htmlspecialchars_decode($title) .'</h5>
					</div>
					'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
				</div>
			</div>
		';
	
	} elseif( 'boxed-color-icon' == $layout ){
		
		$output = '
			<div class="stats-1">
				<div class="feature feature-1 text-center boxed boxed--lg">
					<i class="icon--caviar icon--lg '. esc_attr($icon) .' color--primary"></i>
					<h3>'. htmlspecialchars_decode($title) .'</h3>
					'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
				</div>
			</div>
		';
	
	} elseif( 'combined' == $layout ){
		
		$output = '
			<div class="feature feature-2 '. esc_attr($alignment) .'">
				<div class="feature__title">
					<i class="icon--caviar '. esc_attr($icon) .'"></i>
					<h6>'. htmlspecialchars_decode($title) .'</h6>
				</div>
				'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
			</div>
		';
	
	} elseif( 'side-small' == $layout ){
		
		$output = '
			<div class="feature feature-3 '. esc_attr($alignment) .'">
				<div class="feature__left">
					<i class="icon--caviar '. esc_attr($icon) .'"></i>
				</div>
				<div class="feature__right">
					<h6>'. htmlspecialchars_decode($title) .'</h6>
					'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
				</div>
			</div>
		';
	
	} elseif( 'side-small-color' == $layout ){
		
		$output = '
			<div class="feature feature-3 '. esc_attr($alignment) .'">
				<div class="feature__left">
					<i class="icon--caviar '. esc_attr($icon) .' color--primary"></i>
				</div>
				<div class="feature__right">
					<h5>'. htmlspecialchars_decode($title) .'</h5>
					'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
				</div>
			</div>
		';
	
	} elseif( 'side-large' == $layout ){
		
		$output = '
			<div class="feature feature-3 '. esc_attr($alignment) .'">
				<div class="feature__left">
					<i class="icon--caviar icon--lg '. esc_attr($icon) .'"></i>
				</div>
				<div class="feature__right">
					<h4>'. htmlspecialchars_decode($title) .'</h4>
					'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
				</div>
			</div>
		';
	
	} elseif( 'boxed-large' == $layout ){
		
		$output = '	
			<div class="feature boxed feature-1 text-center">
				<i class="icon--caviar icon--lg '. esc_attr($icon) .'"></i>
				<h4>'. htmlspecialchars_decode($title) .'</h4>
				'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'</div>
		';
	
	} 
	
	return $output;
}
add_shortcode( 'caviar_icon_box', 'thedux_icon_box_shortcode' );

/**
 * The VC Functions
 */
function thedux_icon_box_shortcode_vc() {
	
	$icons = array('Install Themedeux Framework' => 'Install Themedeux Framework');
	
	if( function_exists('thedux_get_icons') ){
		$icons = thedux_get_icons();	
	}
	
	vc_map( 
		array(
			"icon" => 'caviar-vc-block',
			"name" => esc_html__("Icon & Text", 'caviar'),
			"base" => "caviar_icon_box",
			"category" => esc_html__('Caviar Theme', 'caviar'),
			"params" => array(
				array(
					"type" => "thedux_icons",
					"heading" => esc_html__("Click an Icon to choose", 'caviar'),
					"param_name" => "icon",
					"value" => $icons,
					'description' => 'Type "none" or leave blank to hide icons.'
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Title", 'caviar'),
					"param_name" => "title",
					'holder' => 'div',
				),
				array(
					"type" => "textarea_html",
					"heading" => esc_html__("Block Content", 'caviar'),
					"param_name" => "content",
					'holder' => 'div'
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Icon Box Display Type", 'caviar'),
					"param_name" => "layout",
					"value" => array(
						'Standard' => 'standard',
						'Small' => 'small',
						'Large' => 'large',
						'Large with Colored Icon' => 'large-colored',
						'Boxed' => 'boxed',
						'Boxed With Colored Icon' => 'boxed-color-icon',
						'Boxed Large' => 'boxed-large',
						'Boxed Icon' => 'boxed-icon',
						'Combined Icon + Title' => 'combined',
						'Side Icon Small' => 'side-small',
						'Side Icon Small Colored Icon' => 'side-small-color',
						'Side Icon Large' => 'side-large'
					)
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Alignment", 'caviar'),
					"param_name" => "alignment",
					"value" => array(
						'Text Left' => 'standard',
						'Text Center' => 'text-center',
						'Text Right' => 'text-right'
					)
				)
			)
		) 
	);
	
}
add_action( 'vc_before_init', 'thedux_icon_box_shortcode_vc' );