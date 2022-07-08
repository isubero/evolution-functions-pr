<?php
/**
 * Promo: Promo Andrea Zambrana Julio 2022
 * Fecha:
 * Descripción: 10%OFF en combos + bandas elásticas + 50% OFF en el programa Mini Band Edition (Kajabi)
 */

/**
 * Add promo product to cart
 */ 
add_action('woocommerce_cart_updated', 'andrea_zambrana_promo', 40);

function andrea_zambrana_promo() {
    
    if ( did_action('woocommerce_cart_updated') > 10 ) {
        return;
    }

    // Bandas elásticas
    $bandas_product_id = wp_get_environment_type() == 'local' ? 2827 : 4000;
    $bandas_cart_id = WC()->cart->generate_cart_id($bandas_product_id);
    $bandas_cart_item_key = WC()->cart->find_product_in_cart($bandas_cart_id);

    if ( WC()->cart->has_discount( 'az' ) && cart_contains_category(18) ) {
        // If promo product is already in cart, update quantity
        if ( $bandas_cart_item_key ) {
            $cart_item = WC()->cart->get_cart_item( $bandas_cart_item_key );

            if ( $cart_item['quantity'] > 1 ) {
                WC()->cart->set_quantity( $bandas_cart_item_key, 1 );
            }
        } else {
            WC()->cart->add_to_cart( $bandas_product_id, 1 );
        }
    } else {
        if ( $bandas_cart_item_key ) {
            WC()->cart->remove_cart_item( $bandas_cart_item_key );
        }
    }
}

/**
 * Add text to order email
 */
add_action( 'woocommerce_email_before_order_table', 'zambrana_email_before_order_table', 20, 4 );

function zambrana_email_before_order_table( $order, $sent_to_admin, $plain_text, $email ) {

    if ( in_array( 'az', $order->get_coupon_codes() ) && order_contains_product_category($order, 'stacks') ) {
        echo '<h2>Obtén 50% de descuento en el programa Mini Band Edition</h2>';
        echo '<p>Como agradecimiento por haber comprado usando el cupón AZ de Andrea Zambrana, te regalamos <strong>50% de descuento</strong> en el programa Mini Band Edition.</p>';
        echo '<p>Tan solo tienes que usar el código de descuento <strong>EVOLUTION</strong></p>';
        echo '<p>Haz clic aquí para obtenerlo: <a href="https://www.andreazambrana.com/taz28-mini-band-edition">Acceder a mini band edition</a></p>';
    }
    
}