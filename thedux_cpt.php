<?php

// Set-up Action and Filter Hooks
register_uninstall_hook(__FILE__, 'thedux_framework_cpt_delete_plugin_options');
add_action('admin_init', 'thedux_framework_cpt_init' );
add_action('admin_menu', 'thedux_framework_cpt_add_options_page');
//RUN ON THEME ACTIVATION
register_activation_hook( __FILE__, 'thedux_framework_cpt_activation' );

// Delete options table entries ONLY when plugin deactivated AND deleted
function thedux_framework_cpt_delete_plugin_options() {
    delete_option('thedux_framework_cpt_display_options');
}

// Flush rewrite rules on activation
function thedux_framework_cpt_activation() {
    flush_rewrite_rules(true);
}

// Init plugin options to white list our options
function thedux_framework_cpt_init(){
    register_setting( 'thedux_framework_cpt_plugin_display_options', 'thedux_framework_cpt_display_options', 'thedux_framework_cpt_validate_display_options' );
}

// Add menu page
if(!( function_exists('thedux_framework_cpt_add_options_page') )){
    function thedux_framework_cpt_add_options_page(){
        $theme = wp_get_theme();
        add_options_page( $theme->get( 'Name' ) . ' Post Type Options', $theme->get( 'Name' ) . ' Post Type Options', 'manage_options', __FILE__, 'thedux_framework_cpt_render_form');
    }
}

// Render the Plugin options form
function thedux_framework_cpt_render_form() { 
    $theme = wp_get_theme();
?>
    
    <div class="wrap">
    
        <!-- Display Plugin Icon, Header, and Description -->
        <?php screen_icon('thedux-cpt'); ?>
        <h2><?php echo $theme->get( 'Name' ) . __(' Custom Post Type Settings','thedux'); ?></h2>
        <b>When you make any changes in this plugin, be sure to visit <a href="options-permalink.php">Your Permalink Settings</a> & click the 'save changes' button to refresh & re-write your permalinks, otherwise your changes will not take effect properly.</b>
        
        <div class="wrap">
        
            <!-- Beginning of the Plugin Options Form -->
            <form method="post" action="options.php">
                <?php settings_fields('thedux_framework_cpt_plugin_display_options'); ?>
                <?php $displays = get_option('thedux_framework_cpt_display_options'); ?>
                
                <table class="form-table">
                <!-- Checkbox Buttons -->
                    <tr valign="top">
                        <th scope="row">Register Post Types</th>
                        <td>

                            <label><b>Enter the URL slug you want to use for this post type. DO-NOT: use numbers, spaces, capital letters or special characters.</b><br /><br />
                            <input type="text" size="30" name="thedux_framework_cpt_display_options[portfolio_slug]" value="<?php echo $displays['portfolio_slug']; ?>" placeholder="portfolio" /><br />
                             <br />e.g Entering 'portfolio' will result in www.website.com/portfolio becoming the URL to your portfolio.<br />
                             <b>If you change this setting, be sure to visit <a href="options-permalink.php">Your Permalink Settings</a> & click the 'save changes' button to refresh & re-write your permalinks.</b></label>
                             
                             <br />
                             <hr />
                             <br />

                            <label><b>Enter the URL slug you want to use for this post type. DO-NOT: use numbers, spaces, capital letters or special characters.</b><br /><br />
                            <input type="text" size="30" name="thedux_framework_cpt_display_options[team_slug]" value="<?php echo $displays['team_slug']; ?>" placeholder="team" /><br />
                             <br />e.g Entering 'team' will result in www.website.com/team becoming the URL to your team.<br />
                             <b>If you change this setting, be sure to visit <a href="options-permalink.php">Your Permalink Settings</a> & click the 'save changes' button to refresh & re-write your permalinks.</b></label>

                             <br />
                             <hr />
                             <br />

                            <label><b>Enter the URL slug you want to use for this post type. DO-NOT: use numbers, spaces, capital letters or special characters.</b><br /><br />
                            <input type="text" size="30" name="thedux_framework_cpt_display_options[case_studies_slug]" value="<?php echo $displays['case_studies_slug']; ?>" placeholder="case-studies" /><br />
                             <br />e.g Entering 'case-studies' will result in www.website.com/case-studies becoming the URL to your case studies.<br />
                             <b>If you change this setting, be sure to visit <a href="options-permalink.php">Your Permalink Settings</a> & click the 'save changes' button to refresh & re-write your permalinks.</b></label>
                             
                        </td>
                    </tr>
                </table>
                
                <?php submit_button('Save Options'); ?>
                
            </form>
        
        </div>

    </div>
<?php 
}

/**
 * Validate inputs for post type options form
 */
function thedux_framework_cpt_validate_display_options($input) {
    
    if( get_option('thedux_framework_cpt_display_options') ){
        
        $displays = get_option('thedux_framework_cpt_display_options');
        
        foreach ($displays as $key => $value) {
            if(isset($input[$key])){
                $input[$key] = wp_filter_nohtml_kses($input[$key]);
            }
        }
    
    }
    return $input;
    
}

function thedux_framework_register_mega_menu() {

    $labels = array( 
        'name' => __( 'Themedeux Mega Menu', 'thedux' ),
        'singular_name' => __( 'Themedeux Mega Menu Item', 'thedux' ),
        'add_new' => __( 'Add New', 'thedux' ),
        'add_new_item' => __( 'Add New Themedeux Mega Menu Item', 'thedux' ),
        'edit_item' => __( 'Edit Themedeux Mega Menu Item', 'thedux' ),
        'new_item' => __( 'New Themedeux Mega Menu Item', 'thedux' ),
        'view_item' => __( 'View Themedeux Mega Menu Item', 'thedux' ),
        'search_items' => __( 'Search Themedeux Mega Menu Items', 'thedux' ),
        'not_found' => __( 'No Themedeux Mega Menu Items found', 'thedux' ),
        'not_found_in_trash' => __( 'No Themedeux Mega Menu Items found in Trash', 'thedux' ),
        'parent_item_colon' => __( 'Parent Themedeux Mega Menu Item:', 'thedux' ),
        'menu_name' => __( 'Themedeux Mega Menu', 'thedux' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'menu_icon' => 'dashicons-menu',
        'description' => __('Mega Menus entries for the theme.', 'thedux'),
        'supports' => array( 'title', 'editor', 'author' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 40,
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'has_archive' => false,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => false,
        'capability_type' => 'post'
    );

    register_post_type( 'mega_menu', $args );
}

function thedux_framework_register_portfolio() {

$displays = get_option('thedux_framework_cpt_display_options');

if( $displays['portfolio_slug'] ){ $slug = $displays['portfolio_slug']; } else { $slug = 'portfolio'; }

    $labels = array( 
        'name' => __( 'Portfolio', 'thedux' ),
        'singular_name' => __( 'Portfolio', 'thedux' ),
        'add_new' => __( 'Add New', 'thedux' ),
        'add_new_item' => __( 'Add New Portfolio', 'thedux' ),
        'edit_item' => __( 'Edit Portfolio', 'thedux' ),
        'new_item' => __( 'New Portfolio', 'thedux' ),
        'view_item' => __( 'View Portfolio', 'thedux' ),
        'search_items' => __( 'Search Portfolios', 'thedux' ),
        'not_found' => __( 'No portfolios found', 'thedux' ),
        'not_found_in_trash' => __( 'No portfolios found in Trash', 'thedux' ),
        'parent_item_colon' => __( 'Parent Portfolio:', 'thedux' ),
        'menu_name' => __( 'Portfolio', 'thedux' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('Portfolio entries for the thedux Theme.', 'thedux'),
        'supports' => array( 'title', 'editor', 'thumbnail', 'post-formats', 'comments', 'author' ),
        'taxonomies' => array( 'portfolio-category' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-portfolio',
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => array( 'slug' => $slug ),
        'capability_type' => 'post'
    );

    register_post_type( 'portfolio', $args );
}

function thedux_framework_create_portfolio_taxonomies(){
    $labels = array(
        'name' => _x( 'Portfolio Categories','thedux' ),
        'singular_name' => _x( 'Portfolio Category','thedux' ),
        'search_items' =>  __( 'Search Portfolio Categories','thedux' ),
        'all_items' => __( 'All Portfolio Categories','thedux' ),
        'parent_item' => __( 'Parent Portfolio Category','thedux' ),
        'parent_item_colon' => __( 'Parent Portfolio Category:','thedux' ),
        'edit_item' => __( 'Edit Portfolio Category','thedux' ), 
        'update_item' => __( 'Update Portfolio Category','thedux' ),
        'add_new_item' => __( 'Add New Portfolio Category','thedux' ),
        'new_item_name' => __( 'New Portfolio Category Name','thedux' ),
        'menu_name' => __( 'Portfolio Categories','thedux' ),
      );    
  register_taxonomy('portfolio_category', array('portfolio'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => true,
  ));
}

function thedux_framework_register_team() {

$displays = get_option('thedux_framework_cpt_display_options');

if( $displays['team_slug'] ){ $slug = $displays['team_slug']; } else { $slug = 'team'; }

    $labels = array( 
        'name' => __( 'Team Members', 'thedux' ),
        'singular_name' => __( 'Team Member', 'thedux' ),
        'add_new' => __( 'Add New', 'thedux' ),
        'add_new_item' => __( 'Add New Team Member', 'thedux' ),
        'edit_item' => __( 'Edit Team Member', 'thedux' ),
        'new_item' => __( 'New Team Member', 'thedux' ),
        'view_item' => __( 'View Team Member', 'thedux' ),
        'search_items' => __( 'Search Team Members', 'thedux' ),
        'not_found' => __( 'No Team Members found', 'thedux' ),
        'not_found_in_trash' => __( 'No Team Members found in Trash', 'thedux' ),
        'parent_item_colon' => __( 'Parent Team Member:', 'thedux' ),
        'menu_name' => __( 'Team Members', 'thedux' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('Team Member entries for the thedux Theme.', 'thedux'),
        'supports' => array( 'title', 'thumbnail', 'editor', 'author' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-groups',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => array( 'slug' => $slug ),
        'capability_type' => 'post'
    );

    register_post_type( 'team', $args );
}

function thedux_framework_create_team_taxonomies(){
    
    $labels = array(
        'name' => _x( 'Team Categories','thedux' ),
        'singular_name' => _x( 'Team Category','thedux' ),
        'search_items' =>  __( 'Search Team Categories','thedux' ),
        'all_items' => __( 'All Team Categories','thedux' ),
        'parent_item' => __( 'Parent Team Category','thedux' ),
        'parent_item_colon' => __( 'Parent Team Category:','thedux' ),
        'edit_item' => __( 'Edit Team Category','thedux' ), 
        'update_item' => __( 'Update Team Category','thedux' ),
        'add_new_item' => __( 'Add New Team Category','thedux' ),
        'new_item_name' => __( 'New Team Category Name','thedux' ),
        'menu_name' => __( 'Team Categories','thedux' ),
    ); 
        
    register_taxonomy('team_category', array('team'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => true,
    ));
  
}

function thedux_framework_register_client() {

    $labels = array( 
        'name' => __( 'Clients', 'thedux' ),
        'singular_name' => __( 'Client', 'thedux' ),
        'add_new' => __( 'Add New', 'thedux' ),
        'add_new_item' => __( 'Add New Client', 'thedux' ),
        'edit_item' => __( 'Edit Client', 'thedux' ),
        'new_item' => __( 'New Client', 'thedux' ),
        'view_item' => __( 'View Client', 'thedux' ),
        'search_items' => __( 'Search Clients', 'thedux' ),
        'not_found' => __( 'No Clients found', 'thedux' ),
        'not_found_in_trash' => __( 'No Clients found in Trash', 'thedux' ),
        'parent_item_colon' => __( 'Parent Client:', 'thedux' ),
        'menu_name' => __( 'Clients', 'thedux' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('Client entries.', 'thedux'),
        'supports' => array( 'title', 'thumbnail', 'author' ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-businessman',
        'show_in_nav_menus' => true,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'has_archive' => false,
        'query_var' => false,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'client', $args );
}

function thedux_framework_create_client_taxonomies(){
    
    $labels = array(
        'name' => _x( 'Client Categories','thedux' ),
        'singular_name' => _x( 'Client Category','thedux' ),
        'search_items' =>  __( 'Search Client Categories','thedux' ),
        'all_items' => __( 'All Client Categories','thedux' ),
        'parent_item' => __( 'Parent Client Category','thedux' ),
        'parent_item_colon' => __( 'Parent Client Category:','thedux' ),
        'edit_item' => __( 'Edit Client Category','thedux' ), 
        'update_item' => __( 'Update Client Category','thedux' ),
        'add_new_item' => __( 'Add New Client Category','thedux' ),
        'new_item_name' => __( 'New Client Category Name','thedux' ),
        'menu_name' => __( 'Client Categories','thedux' ),
    ); 
        
    register_taxonomy('client_category', array('client'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => true,
    ));
  
}

function thedux_framework_register_testimonial() {

    $labels = array( 
        'name' => __( 'Testimonials', 'thedux' ),
        'singular_name' => __( 'Testimonial', 'thedux' ),
        'add_new' => __( 'Add New', 'thedux' ),
        'add_new_item' => __( 'Add New Testimonial', 'thedux' ),
        'edit_item' => __( 'Edit Testimonial', 'thedux' ),
        'new_item' => __( 'New Testimonial', 'thedux' ),
        'view_item' => __( 'View Testimonial', 'thedux' ),
        'search_items' => __( 'Search Testimonials', 'thedux' ),
        'not_found' => __( 'No Testimonials found', 'thedux' ),
        'not_found_in_trash' => __( 'No Testimonials found in Trash', 'thedux' ),
        'parent_item_colon' => __( 'Parent Testimonial:', 'thedux' ),
        'menu_name' => __( 'Testimonials', 'thedux' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('Testimonial entries.', 'thedux'),
        'supports' => array( 'title', 'editor', 'author' ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-editor-quote',
        'show_in_nav_menus' => true,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'has_archive' => false,
        'query_var' => false,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'testimonial', $args );
}

function thedux_framework_create_testimonial_taxonomies(){
    
    $labels = array(
        'name' => _x( 'Testimonial Categories','thedux' ),
        'singular_name' => _x( 'Testimonial Category','thedux' ),
        'search_items' =>  __( 'Search Testimonial Categories','thedux' ),
        'all_items' => __( 'All Testimonial Categories','thedux' ),
        'parent_item' => __( 'Parent Testimonial Category','thedux' ),
        'parent_item_colon' => __( 'Parent Testimonial Category:','thedux' ),
        'edit_item' => __( 'Edit Testimonial Category','thedux' ), 
        'update_item' => __( 'Update Testimonial Category','thedux' ),
        'add_new_item' => __( 'Add New Testimonial Category','thedux' ),
        'new_item_name' => __( 'New Testimonial Category Name','thedux' ),
        'menu_name' => __( 'Testimonial Categories','thedux' ),
    ); 
        
    register_taxonomy('testimonial_category', array('testimonial'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => true,
    ));
  
}

function thedux_framework_register_faq() {

    $labels = array( 
        'name' => __( 'FAQs', 'thedux' ),
        'singular_name' => __( 'FAQ', 'thedux' ),
        'add_new' => __( 'Add New', 'thedux' ),
        'add_new_item' => __( 'Add New FAQ', 'thedux' ),
        'edit_item' => __( 'Edit FAQ', 'thedux' ),
        'new_item' => __( 'New FAQ', 'thedux' ),
        'view_item' => __( 'View FAQ', 'thedux' ),
        'search_items' => __( 'Search FAQs', 'thedux' ),
        'not_found' => __( 'No faqs found', 'thedux' ),
        'not_found_in_trash' => __( 'No FAQs found in Trash', 'thedux' ),
        'parent_item_colon' => __( 'Parent FAQ:', 'thedux' ),
        'menu_name' => __( 'FAQs', 'thedux' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('FAQ Entries.', 'thedux'),
        'supports' => array( 'title', 'editor', 'author' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-welcome-learn-more',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => true,
        'has_archive' => false,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'faq', $args );
}

function thedux_framework_create_faq_taxonomies(){
    
    $labels = array(
        'name' => _x( 'FAQ Categories','thedux' ),
        'singular_name' => _x( 'FAQ Category','thedux' ),
        'search_items' =>  __( 'Search FAQ Categories','thedux' ),
        'all_items' => __( 'All FAQ Categories','thedux' ),
        'parent_item' => __( 'Parent FAQ Category','thedux' ),
        'parent_item_colon' => __( 'Parent FAQ Category:','thedux' ),
        'edit_item' => __( 'Edit FAQ Category','thedux' ), 
        'update_item' => __( 'Update FAQ Category','thedux' ),
        'add_new_item' => __( 'Add New FAQ Category','thedux' ),
        'new_item_name' => __( 'New FAQ Category Name','thedux' ),
        'menu_name' => __( 'FAQ Categories','thedux' ),
    ); 
        
    register_taxonomy('faq_category', array('faq'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => true,
    ));
  
}

function thedux_framework_register_menu() {

    $labels = array( 
        'name' => __( 'Menu Items', 'thedux' ),
        'singular_name' => __( 'Menu Item', 'thedux' ),
        'add_new' => __( 'Add New', 'thedux' ),
        'add_new_item' => __( 'Add New Menu Item', 'thedux' ),
        'edit_item' => __( 'Edit Menu Item', 'thedux' ),
        'new_item' => __( 'New Menu Item', 'thedux' ),
        'view_item' => __( 'View Menu Item', 'thedux' ),
        'search_items' => __( 'Search Menu Items', 'thedux' ),
        'not_found' => __( 'No Menu Items found', 'thedux' ),
        'not_found_in_trash' => __( 'No Menu Items found in Trash', 'thedux' ),
        'parent_item_colon' => __( 'Parent Menu Item:', 'thedux' ),
        'menu_name' => __( 'Menu Items', 'thedux' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('Menu Item Entries.', 'thedux'),
        'supports' => array( 'title', 'editor', 'author' ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-carrot',
        'show_in_nav_menus' => false,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'has_archive' => false,
        'query_var' => false,
        'can_export' => true,
        'rewrite' => false,
        'capability_type' => 'post'
    );

    register_post_type( 'menu', $args );
}

function thedux_framework_create_menu_taxonomies(){
    
    $labels = array(
        'name' => _x( 'Menu Item Categories','thedux' ),
        'singular_name' => _x( 'Menu Item Category','thedux' ),
        'search_items' =>  __( 'Search Menu Item Categories','thedux' ),
        'all_items' => __( 'All Menu Item Categories','thedux' ),
        'parent_item' => __( 'Parent Menu Item Category','thedux' ),
        'parent_item_colon' => __( 'Parent Menu Item Category:','thedux' ),
        'edit_item' => __( 'Edit Menu Item Category','thedux' ), 
        'update_item' => __( 'Update Menu Item Category','thedux' ),
        'add_new_item' => __( 'Add New Menu Item Category','thedux' ),
        'new_item_name' => __( 'New Menu Item Category Name','thedux' ),
        'menu_name' => __( 'Menu Item Categories','thedux' ),
    ); 
        
    register_taxonomy('menu_category', array('menu'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => false,
        'rewrite' => false,
    ));
  
}

