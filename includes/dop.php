<?php 
    global $img_catalogs;
    print_r($img_catalogs); 
?>
    <h2>Настройки выбора тканей для кресел beanbag</h2>
    
    <div id="content">

	<h2 class="nav-tab-wrapper add_tip_wrap">    
<?php
    $i=0;
    if ($i == 0) {
?>
        <a class="bb-tab nav-tab <?php echo $fname; ?>-tab nav-tab-active"  data-target="#<?php echo $fname; ?>"><?php _e( strtoupper($fname), 'woocommerce-beanbag-pattern' ); ?></a>
<?php } else { ?>
        <a class="bb-tab nav-tab <?php echo $fname; ?>-tab" data-target="#<?php echo $fname; ?>"><?php _e( strtoupper($fname), 'woocommerce-beanbag-pattern' ); ?></a>
	
	
	<?php  }
    ?>
    </h2>
	<!-- .nav-tab-wrapper -->
	
<?php
        
        function my_woocommerce_available_variation($available_variation, $product, $variation) {
//    $available_variation['weight'] = $variation->has_weight() ? "Вес товара: ".$variation->get_weight()." гр." : "";
//    return $available_variation;
    print_r( $available_variation);
}
//add_filter( 'woocommerce_available_variation', 'my_woocommerce_available_variation', 20, 3 );
    function override_variation_option($html, $args){
        $html = 'Some override';

        return $html;
    }
    //add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'override_variation_option');