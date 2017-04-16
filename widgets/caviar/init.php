<?php
add_action( 'widgets_init', 'thedux_woocommerce_widgets', 15 );
function thedux_woocommerce_widgets() {
    if ( class_exists( 'WC_Widget_Layered_Nav' ) ) {
        unregister_widget( 'WC_Widget_Layered_Nav' );
        require_once(THEDUX_FRAMEWORK_PATH . 'widgets/caviar/class-wc-widget-layered-nav.php');
        register_widget( 'Thedux_Widget_Layered_Nav' );
    }

}