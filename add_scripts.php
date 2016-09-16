<?php
   function woo_bb_adding_scripts() {
    wp_register_style( 'tingle-style', plugins_url( '/css/tingle.min.css', __FILE__ ), array(), '1.1', 'all' );  
    wp_enqueue_style( 'tingle-style' ); 
    wp_register_style( 'bb-pattern-style', plugins_url( '/css/bb-pattern.css', __FILE__ ), array(), '1.1', 'all' );  
    wp_enqueue_style( 'bb-pattern-style' ); 

    wp_register_script('tingle', plugins_url('js/tingle.min.js', __FILE__), array('jquery'),'1.1', true);
    wp_enqueue_script('tingle');
    wp_register_script('bb-pattern', plugins_url('js/bb-pattern.js', __FILE__), array('jquery'),'1.1', true);
    wp_enqueue_script('bb-pattern');
    wp_localize_script('bb-pattern', '_bbVar', array('for_script' => __( 'img path' ), 'bb_site' => plugins_url( '/images/', __FILE__ )));

}
add_action( 'wp_enqueue_scripts', 'woo_bb_adding_scripts' );

function bb_admin_init() {
    wp_register_style( 'bb-admin-style', plugins_url( '/css/bb-admin-style.css', __FILE__ ), array(), '1.1', 'all' );
    wp_register_script( 'bb-admin-script', plugins_url('js/bb-admin-script.js', __FILE__), array('jquery'),'1.1', true );
    
}
add_action( 'admin_init', 'bb_admin_init' );
    
function bb_admin_menu() {

    $page = add_menu_page( 'WooBeanbag', 'Выбор ткани', 'manage_options', 'woocommerce-baenbag-pattern' , 'woo_bb_options_page', 'dashicons-screenoptions', 58);
    //add_submenu_page( 'woocommerce-checkout-manager', 'Export', 'Export', 'manage_options', 'wooccm-advance-export', 'wooccm_advance_export' );
    add_action( 'admin_print_scripts-' . $page, 'bb_pattern_admin_scripts' );

}
add_action( 'admin_menu', 'bb_admin_menu' );
function bb_pattern_admin_scripts() {
    wp_enqueue_script( 'bb-admin-script' );
    wp_enqueue_style( 'bb-admin-style' );
}
