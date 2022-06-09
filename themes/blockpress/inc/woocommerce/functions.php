<?php
/**
 * Blockpress: Woocommerce
 *
 * @since Blockpress 0.8.0
 */

add_theme_support( 'woocommerce');

//////////////////////////////////////////////////////////////////
// WooCommerce Assets
//////////////////////////////////////////////////////////////////

add_action('init', 'blockpress_theme_register_woo_assets');
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
add_action('wp_enqueue_scripts', 'blockpress_woo_enqueue', 11);

function blockpress_theme_register_woo_assets(){

    wp_register_style('woocommerce-general', BLOCKPRESS_THEME_DIR . '/assets/woocommerce/css/woocommerce.css', array(), BLOCKPRESS_THEME_VERSION);
    wp_style_add_data( 'woocommerce-general', 'rtl', 'replace' );

    wp_register_style('woocommerce-smallscreen', BLOCKPRESS_THEME_DIR . '/assets/woocommerce/css/woocommerce-smallscreen.css', array('woocommerce-general'), BLOCKPRESS_THEME_VERSION, 'only screen and (max-width: ' . apply_filters( 'woocommerce_style_smallscreen_breakpoint', '768px' ) . ')');
    wp_style_add_data( 'woocommerce-layout', 'rtl', 'replace' );

	wp_register_style('blockpress-woo-single', BLOCKPRESS_THEME_DIR . '/assets/woocommerce/css/woosingle.css', array('woocommerce-general'), BLOCKPRESS_THEME_VERSION);
    wp_style_add_data( 'blockpress-woo-single', 'rtl', 'replace' );

    wp_register_style('blockpress-quantity', BLOCKPRESS_THEME_DIR . '/assets/qty/style.css', array(), BLOCKPRESS_THEME_VERSION);
    wp_register_script('blockpress-quantity', BLOCKPRESS_THEME_DIR . '/assets/qty/index.min.js', array(), BLOCKPRESS_THEME_VERSION, true);
	
    wp_register_style('blockpress-woo-comments', BLOCKPRESS_THEME_DIR . '/assets/woocommerce/css/woocomments.css', array('woocommerce-general'), BLOCKPRESS_THEME_VERSION);

}

if (!function_exists('blockpress_woo_enqueue')){
    function blockpress_woo_enqueue() {   

        wp_enqueue_style( 'woocommerce-general');
        wp_enqueue_style( 'blockpress-quantity');
        wp_enqueue_script( 'blockpress-quantity');

		if(is_singular('product')){
			wp_enqueue_style('blockpress-woo-single');
		} 

        wp_enqueue_style( 'woocommerce-smallscreen');
    } 
}


//Helpers
function blockpress_get_ratings_counts( $product ) {
    global $wpdb;
    
    $counts     = array();
    $raw_counts = $wpdb->get_results( $wpdb->prepare("
            SELECT meta_value, COUNT( * ) as meta_value_count FROM $wpdb->commentmeta
            LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
            WHERE meta_key = 'rating'
            AND comment_post_ID = %d
            AND comment_approved = '1'
            AND meta_value > 0
            GROUP BY meta_value
        ", $product->get_id() ) );
    
    foreach ( $raw_counts as $count ) {
        $counts[ $count->meta_value ] = $count->meta_value_count;
    }
    
    return $counts;
}	

function fr_woo_rating_icons_html($rating, $count){
	$html = '';
	if($rating > 0){
		$rating = round($rating, 2);
		for ($i = 1; $i <= 5; $i++){
	    	if ($i <= $rating){
	    		$active = ' active';
	    	}else{
	    		$half = $i - 0.5;
	    		if($half <= $rating){
		    		$active = ' halfactive';		    			
	    		}else{
	    			$active ='';
	    		}
	    	}
	        $html .= '<span class="frwoostar frwoostar'.$i.$active.'">&#9733;</span>';
		}
	}
	return $html;
}

remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

add_action( 'woocommerce_checkout_before_order_review_heading', 'blockpress_woo_order_checkout' );
add_action( 'woocommerce_checkout_after_order_review', 'blockpress_woo_after_order_checkout' );
add_action( 'woocommerce_before_checkout_form', 'blockpress_woo_style_checkout' );
add_action( 'woocommerce_before_cart', 'blockpress_woo_style_cart' );
add_action( 'woocommerce_after_cart_table', 'woocommerce_cross_sell_display' );

function blockpress_woo_order_checkout() {
	echo '<div class="re_woocheckout_order">';
}
function blockpress_woo_after_order_checkout() {
	echo '</div><div class="clearfix"></div>';
}
function blockpress_woo_style_checkout() {
    echo blockpress_generate_incss('checkoutcart');
	echo blockpress_generate_incss('woocheckout');
}
function blockpress_woo_style_cart() {
    echo blockpress_generate_incss('checkoutcart');
	echo blockpress_generate_incss('woocart');
}