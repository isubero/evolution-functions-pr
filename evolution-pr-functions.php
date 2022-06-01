<?php
/**
 * Plugin Name: Evolution Functions PR
 * Plugin URI: https://isaiassubero.com
 * Description: Personalizaciones para Evolution Puerto Rico.
 * Version: 1.0
 * Author: Isaías Subero
 * Author URI: https://isaiassubero.com
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: evolution-functions
 * Domain Path: /languages
 */

if ( ! defined('ABSPATH') ) {
    exit; // Exit if accessed directly
}

class Evolution_Functions {
    public function __construct() {
        // Set plugin path
        define( 'EVOLUTION_FUNCTIONS_PLUGIN_PATH', plugin_dir_path(__FILE__) );

        // Register ATH Móvil payment gateway
        include_once 'includes/payment-gateways/ath-movil/ath-movil.php';

        // Restrict payment gateways by role
        add_filter( 'woocommerce_available_payment_gateways', array($this, 'evolution_available_payment_gateways') );
    }

    /**
     * Restrict payment gateways by role
     */
    public function evolution_available_payment_gateways( $available_gateways ) {
        if ( isset( $available_gateways['ath_movil'] ) && !current_user_can('manage_woocommerce') ) {
            unset( $available_gateways['ath_movil'] );
        }

        return $available_gateways;
    }
}

new Evolution_Functions;