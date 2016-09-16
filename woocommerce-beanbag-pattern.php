<?php
/*
Plugin Name: Woo-commerce Beanbang Pattern
Plugin URI: https://anika-themes.in.ua/plugins/beanbang/
Description: Add options to woo-commerce products/Добавляет возможность выбора тканей для магазина
Version: 1.0.0
Author: Olena Slutska
Author URI: http://anika-themes.in.ua
Text Domain: beanbang
Domain Path: /languages

Copyright: © 2016 Olena Slutska
Tags: options, pattern, variations
Requires at least: 4.0.1
Tested up to: 4.3
Stable tag: 4.3
License: GPLv3 or later License
URI: https://www.gnu.org/licenses/gpl-3.0.html
WC requires at least: 2.2
WC tested up to: 2.6.4
*/
//https://codex.wordpress.org/File_Header
if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}
//https://wp-panda.com/woocommerce_posts/create-a-plugin/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    // Ваш код плагина
    define( 'BB_PATH', plugin_dir_path( __FILE__ ) );
    define( 'IMAGE_URL', plugin_dir_url( __FILE__ ).'images/' );
    define( 'IMAGE_PATH',  wp_normalize_path(plugin_dir_path(__FILE__).'/images/'));
    include_once(BB_PATH.'includes/beanbag-admin.php');
   // include_once('includes/dop.php');
    include_once('add_scripts.php');
/**
* WooCommerce: выводим пользовательское свойство товара над кнопкой "Добавить в корзину" на странице отдельного товара.
*/
    global $pattern_arr;
    $pattern_arr = array();
function bb_woo_get_taxonomy(){
    global $pattern_arr;
    global $product;
    global $post;
    $attributes = $product->get_attributes();

   if ( ! $attributes ) {  
       return;     
   }
// http://code.tutsplus.com/tutorials/how-to-make-woocommerce-product-attributes-more-prominent--cms-25438
    foreach ( $attributes as $attribute ) {

        // Get the taxonomy.
        $terms = wp_get_post_terms( $product->id, $attribute[ 'name' ], 'all' );
        $taxonomy = $terms[ 0 ]->taxonomy;

        // Get the taxonomy object.
        $taxonomy_object = get_taxonomy( $taxonomy );

        // Get the attribute label.
     $attribute_label = $taxonomy_object->labels->name;
     
     if($attribute_label == 'ткань'){
        $patterns = get_the_terms( $post->ID, $attribute[ 'name' ] );
        foreach( $patterns as $pattern ){
            $pattern_arr[] = $pattern->slug;

        }
        show_pattern_set($pattern_arr);
         // echo get_the_term_list( $post->ID, $attribute[ 'name' ] , '<div class="attributes">' . $attribute_label . ': ' , ', ', '</div>' );
        echo '<div class="bb-wrapper"><p>Нажмите на кнопке, чтобы:</p>
        <button id="bb-choose-pattern">Выбрать ткань</button>
        <div class="bb-pull-left bb-hide">
            <span>Ваш выбор</span>
            <img id="user-choose-pic" src="" alt="Основная ткань"> 
            <span id="user-choose">Oxford графит</span>
        </div>
    </div>';
     }
        // Display the label followed by a clickable list of terms.
      
       
    if($attribute_label == 'цвет вставки'){
        echo '<div class="bb-wrapper"><button id="bb-vstavka-pattern" name="bb-vstavka-pattern" class="disabled">Выбрать ткань вставки</button>
        <div class="bb-pull-left bb-hide">
            <span>Ваш выбор</span>
            <img id="user-dop-pic" src="" alt="Ткань вставки"> 
            <span id="user-dop-choose">Oxford графит</span>
        </div>
        </div>';
    }
        
    }
    
}
 
add_action('woocommerce_single_product_summary', 'bb_woo_get_taxonomy');
      
    
    
    function show_pattern_set($arr){
        $str = '<div class="tbl">';
       // echo(count($arr));
        foreach($arr as $num => $pattern){
            $bb_option = get_option( 'bb_'.$pattern );

            $div = '
            <div class="bb-option" id="'.$pattern.'">
              <div class="bb-wrapper">
                <form name="bb-'.$pattern.'" id="bb-'.$pattern.'">';
            foreach($bb_option as $option => $value){
                //echo $option."=".$value."<br>";
                
                if( strripos($option, $pattern)!== false) continue;
                else if($option === "descr") $div .= '<h2>О ткани '.strtoupper($pattern).'</h2><p>'.stripslashes_deep($value).'</p>';
                 else   $div.='
                <div class="bb-form-control">
                <input type="radio" name="'.$pattern.'" value="'.$bb_option[$pattern.''.$option].'" id="'.$pattern.''.$option.'">
                <label for="'.$pattern.$option.'"><img src="'.$value.'" alt="'.$bb_option[$pattern.$option].'"></label>
                <label for="'.$pattern.$option.'">'.$bb_option[$pattern.$option].'</label></div>';

            }
            $div .='
                </form>
              </div><!--/ .bb-wrapper -->
            </div><!--/ .bb-option -->';
            echo $div;
        }   
    }//end show_pattern_set()
    
    add_filter( 'woocommerce_product_single_add_to_cart_text', 'bb_woo_custom_cart_button_text' );    // 2.1 +
 
    function bb_woo_custom_cart_button_text() {

            return __( 'Заказать', 'woocommerce' );

    }
}//active plugins if

//http://wpincode.com/vyvodim-polzovatelskie-svojstva-tovarov-v-woocommerce-na-stranice-tovara/