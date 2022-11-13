<?php
/**
 * Promo: Promo Black Friday 2022
 * Fecha:
 * Descripción: Con la compra de cualquier combo: 2 ebooks de regalo, 
 * libro físico de Andrea Zambrana, 30% de descuento en programas de Andrea Zambrana
 * y 15% de descuento en todos los combos de Evolution Advance
 */

/**
 * Add promo product to cart
 */ 
add_action('woocommerce_cart_updated', 'black_friday_promo', 40);

function black_friday_promo() {
    
    if ( did_action('woocommerce_cart_updated') > 10 ) {
        return;
    }

    // Black friday product
    $bf_product_id = wp_get_environment_type() == 'local' ? 2857 : null;
    $bf_cart_id = WC()->cart->generate_cart_id($bf_product_id);
    $bf_cart_item_key = WC()->cart->find_product_in_cart($bf_cart_id);

    if ( cart_contains_category(18) ) {
        // If promo product is already in cart, update quantity
        if ( $bf_cart_item_key ) {
            $cart_item = WC()->cart->get_cart_item( $bf_cart_item_key );

            if ( $cart_item['quantity'] > 1 ) {
                WC()->cart->set_quantity( $bf_cart_item_key, 1 );
            }
        } else {
            WC()->cart->add_to_cart( $bf_product_id, 1 );
        }
    } else {
        if ( $bf_cart_item_key ) {
            WC()->cart->remove_cart_item( $bf_cart_item_key );
        }
    }
}

/**
 * Add text to order email
 */
add_action( 'woocommerce_email_before_order_table', 'black_friday_email_before_order_table', 20, 4 );

function black_friday_email_before_order_table( $order, $sent_to_admin, $plain_text, $email ) {

    if ( order_contains_product_category($order, 'stacks') ) {
        echo '<h2>Black Friday</h2>';
        echo '<p>Como agradecimiento por haber participado en la promoción de Black Friday, te regalamos <strong>30% de descuento</strong> en el cualquiera de <a href="https://www.andreazambrana.com/taz28LEG">los programas de Andrea Zambrana</a>.</p>';
        echo '<p>Tan solo tienes que usar el código de descuento <strong>taz30</strong></p>';
        echo '<p>Haz clic aquí para ver los programas disponibles: <a href="https://www.andreazambrana.com/taz28LEG">Programa Andrea Zambrana</a></p>';
    }
    
}