<?php

class theduxLikes {

    function __construct() {	
        add_action('wp_enqueue_scripts', array(&$this, 'enqueue_scripts'));
        add_action('publish_post', array(&$this, 'setup_likes'));
        add_action('wp_ajax_thedux-likes', array(&$this, 'ajax_callback'));
		add_action('wp_ajax_nopriv_thedux-likes', array(&$this, 'ajax_callback'));
        add_shortcode('thedux_likes', array(&$this, 'shortcode'));
	}
	
	function enqueue_scripts(){
	    $options = get_option( 'thedux_likes_settings' );
		if( !isset($options['disable_css']) ) $options['disable_css'] = '0';
		
		if(!$options['disable_css']) wp_enqueue_style( 'thedux-likes', plugins_url( '/styles/thedux-likes.css', __FILE__ ) );
		
		wp_enqueue_script( 'thedux-likes', plugins_url( '/scripts/thedux-likes.js', __FILE__ ), array('jquery') );
		wp_enqueue_script( 'jquery' );
		
		wp_localize_script('thedux-likes', 'thedux', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
        ));
        
		wp_localize_script( 'thedux-likes', 'thedux_likes', array('ajaxurl' => admin_url('admin-ajax.php')) );
	}
	
	function setup_likes( $post_id ) {
		if(!is_numeric($post_id)) return;
	
		add_post_meta($post_id, '_thedux_likes', '0', true);
	}
	
	function ajax_callback($post_id){

		$options = get_option( 'thedux_likes_settings' );
		if( !isset($options['add_to_posts']) ) $options['add_to_posts'] = '0';
		if( !isset($options['add_to_pages']) ) $options['add_to_pages'] = '0';
		if( !isset($options['add_to_other']) ) $options['add_to_other'] = '0';
		if( !isset($options['zero_postfix']) ) $options['zero_postfix'] = '';
		if( !isset($options['one_postfix']) ) $options['one_postfix'] = '';
		if( !isset($options['more_postfix']) ) $options['more_postfix'] = '';

		if( isset($_POST['likes_id']) ) {
		    // Click event. Get and Update Count
			$post_id = str_replace('thedux-likes-', '', $_POST['likes_id']);
			echo $this->like_this($post_id, $options['zero_postfix'], $options['one_postfix'], $options['more_postfix'], 'update');
		} else {
		    // AJAXing data in. Get Count
			$post_id = str_replace('thedux-likes-', '', $_POST['post_id']);
			echo $this->like_this($post_id, $options['zero_postfix'], $options['one_postfix'], $options['more_postfix'], 'get');
		}
		
		exit;
	}
	
	function like_this($post_id, $zero_postfix = false, $one_postfix = false, $more_postfix = false, $action = 'get'){
		if(!is_numeric($post_id)) return;
		$zero_postfix = strip_tags($zero_postfix);
		$one_postfix = strip_tags($one_postfix);
		$more_postfix = strip_tags($more_postfix);		
		
		switch($action) {
		
			case 'get':
				$likes = get_post_meta($post_id, '_thedux_likes', true);
				if( !$likes ){
					$likes = 0;
					add_post_meta($post_id, '_thedux_likes', $likes, true);
				}
				
				if( $likes == 0 ) { $postfix = $zero_postfix; }
				elseif( $likes == 1 ) { $postfix = $one_postfix; }
				else { $postfix = $more_postfix; }
				
				return '<span class="thedux-likes-count">'. $likes .'</span> <span class="thedux-likes-postfix">'. $postfix .'</span>';
				break;
				
			case 'update':
				$likes = get_post_meta($post_id, '_thedux_likes', true);
				if( isset($_COOKIE['thedux_likes_'. $post_id]) ) return $likes;
				
				$likes++;
				update_post_meta($post_id, '_thedux_likes', $likes);
				setcookie('thedux_likes_'. $post_id, $post_id, time()*20, '/');
				
				if( $likes == 0 ) { $postfix = $zero_postfix; }
				elseif( $likes == 1 ) { $postfix = $one_postfix; }
				else { $postfix = $more_postfix; }
				
				return '<span class="thedux-likes-count">'. $likes .'</span> <span class="thedux-likes-postfix">'. $postfix .'</span>';
				break;
		
		}
	}
	
	function shortcode( $atts ){
		extract( shortcode_atts( array(
		), $atts ) );
		
		return $this->do_likes();
	}
	
	function do_likes(){
		global $post;

        $options = get_option( 'thedux_likes_settings' );
		if( !isset($options['zero_postfix']) ) $options['zero_postfix'] = '';
		if( !isset($options['one_postfix']) ) $options['one_postfix'] = '';
		if( !isset($options['more_postfix']) ) $options['more_postfix'] = '';
		
		$output = $this->like_this($post->ID, $options['zero_postfix'], $options['one_postfix'], $options['more_postfix']);
  
  		$class = 'thedux-likes';
  		$title = __('Like this', 'thedux');
		if( isset($_COOKIE['thedux_likes_'. $post->ID]) ){
			$class = 'thedux-likes liked';
			$title = __('You already like this', 'thedux');
		}
		
		return '<a href="#" class="'. $class .'" id="thedux-likes-'. $post->ID .'" title="'. $title .'"><i class="caviar-icon-heart-solid"></i></a>'. $output;
	}
	
}
global $thedux_likes;
$thedux_likes = new theduxLikes();

/**
 * Template Tag
 */
function thedux_likes(){
	global $thedux_likes;
    echo $thedux_likes->do_likes(); 
}